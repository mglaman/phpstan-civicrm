<?php declare(strict_types=1);

namespace PHPStan\CiviCRM\Tests;

use PHPStan\Analyser\Analyser;
use PHPStan\Analyser\AnalyserResult;
use PHPStan\Analyser\Error;
use PHPStan\DependencyInjection\ContainerFactory;
use PHPStan\File\FileHelper;
use PHPUnit\Framework\TestCase;

final class SymbolDiscoveryTest extends TestCase {

    public function testSymbolDiscovery()
    {
        $result = $this->runAnalyze(__DIR__ . '/../fixtures/code/symbol-discovery.php');
        $this->assertCount(0, $result->getErrors(), $this->getErrorMessages($result));
        $this->assertCount(0, $result->getInternalErrors(), implode(PHP_EOL, $result->getInternalErrors()));
    }

    private function runAnalyze(string $path)
    {
        $rootDir = __DIR__ . '/../../';
        $tmpDir = sys_get_temp_dir() . '/' . time() . 'phpstan';
        $containerFactory = new ContainerFactory($rootDir);
        $additionalConfigFiles = [
            \sprintf('%s/config.level%s.neon', $containerFactory->getConfigDirectory(), 8),
            __DIR__ . '/../fixtures/config/baseline.neon',
        ];
        $container = $containerFactory->create($tmpDir, $additionalConfigFiles, []);
        $fileHelper = $container->getByType(FileHelper::class);
        assert($fileHelper instanceof FileHelper);

        $autoloadFiles = $container->getParameter('bootstrapFiles');
        $this->assertContains(dirname(__DIR__, 2) . '/civicrm-autoloader.php', $autoloadFiles);
        if ($autoloadFiles !== null) {
            foreach ($autoloadFiles as $autoloadFile) {
                $autoloadFile = $fileHelper->normalizePath($autoloadFile);
                if (!is_file($autoloadFile)) {
                    $this->fail('Autoload file not found');
                }
                (static function (string $file) use ($container): void {
                    require_once $file;
                })($autoloadFile);
            }
        }

        $analyser = $container->getByType(Analyser::class);
        assert($analyser instanceof Analyser);

        $file = $fileHelper->normalizePath($path);
        $errors = $analyser->analyse(
            [$file],
            null,
            null,
            false,
            null
        );
        assert($errors instanceof AnalyserResult);
        foreach ($errors->getErrors() as $error) {
            $this->assertSame($fileHelper->normalizePath($file), $error->getFile());
        }
        return $errors;
    }

    /**
     * @param \PHPStan\Analyser\AnalyserResult $result
     *
     * @return string[]
     */
    private function getErrorMessages(AnalyserResult $result): string
    {
        return implode(PHP_EOL, array_map(static function (Error $error) {
            return $error->getMessage();
        }, $result->getErrors()));
    }

}
