<?php

namespace App\Factory;

use Cycle\Database\DatabaseManager;
use Cycle\ORM\ORM;
use Cycle\ORM\Schema;
use Cycle\Schema\Compiler;
use Cycle\Schema\Registry;
use Cycle\Schema\Generator;
use Cycle\Annotated;
use Cycle\Annotated\Locator\TokenizerEntityLocator;
use Cycle\Annotated\Locator\TokenizerEmbeddingLocator;
use Cycle\Migrations\Migrator;
use Cycle\ORM\Factory;
use Cycle\Schema\Generator\Migrations\GenerateMigrations;
use Cycle\Schema\Generator\Migrations\NameBasedOnChangesGenerator;
use Cycle\Schema\Generator\Migrations\Strategy\MultipleFilesStrategy;
use Psr\Container\ContainerInterface;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Finder\Finder;

class CycleORMFactory
{
    public function __invoke(ContainerInterface $container): ORM
    {
        $dbal = $container->get(DatabaseManager::class);

        $registry = new Registry($dbal);
        $finder = new Finder();
        $files = $finder->files()->in(
            [__DIR__ . '/../Person/src/Model']
        );
        $classLocator = new ClassLocator($files);
        $embeddingLocator = new TokenizerEmbeddingLocator($classLocator);
        $entityLocator = new TokenizerEntityLocator($classLocator);
        $compiler = new Compiler();

        $migrator = $container->get(Migrator::class);
        $migrator->configure();

        $schemaArray = $compiler->compile($registry, [
            new Generator\ResetTables(),
            new Annotated\Embeddings($embeddingLocator),
            new Annotated\Entities($entityLocator),
            new Annotated\TableInheritance(),
            new Annotated\MergeColumns(),
            new Generator\GenerateRelations(),
            new Generator\GenerateModifiers(),
            new Generator\ValidateEntities(),
            new Generator\RenderTables(),
            new Generator\RenderRelations(),
            new Generator\RenderModifiers(),
            new Generator\ForeignKeys(),
            new Annotated\MergeIndexes(),
            // new Generator\SyncTables(),
            new GenerateMigrations(
                $migrator->getRepository(),
                $migrator->getConfig(),
                new MultipleFilesStrategy(
                    $migrator->getConfig(),
                    new NameBasedOnChangesGenerator()
                )
            ),
            new Generator\GenerateTypecast(),
        ]);

        $schema = new Schema($schemaArray);
        $factory = new Factory($dbal);

        $orm = new ORM(
            factory: $factory,
            schema: $schema,
        );

        return $orm;
    }
}
