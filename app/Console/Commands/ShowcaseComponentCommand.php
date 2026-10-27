<?php

namespace App\Console\Commands;

use App\Showcase\CatalogComponent;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

#[Signature('showcase:component {slug : The component slug from config/showcase.php} {--force : Overwrite an existing screen and view}')]
#[Description('Scaffold the example screen and view for a component in the showcase registry')]
class ShowcaseComponentCommand extends Command
{
    public function handle(): int
    {
        $slug = (string) $this->argument('slug');

        if (config("showcase.components.{$slug}") === null) {
            $this->components->error("[{$slug}] is not in config/showcase.php. Add it under 'components' first.");

            return self::FAILURE;
        }

        $class = Str::studly($slug).'Example';
        $classPath = app_path('NativeComponents/Components/Examples/'.$class.'.php');
        $viewPath = resource_path('views/native/components/examples/'.$slug.'.blade.php');

        $this->write($classPath, $this->classStub($class));
        $this->write($viewPath, $this->viewStub(config("showcase.components.{$slug}.tags.0", $slug)));

        $this->components->info("Scaffolded [{$slug}]. It is routed at /components/{$slug} automatically.");

        return self::SUCCESS;
    }

    private function write(string $path, string $contents): void
    {
        if (File::exists($path) && ! $this->option('force')) {
            $this->components->warn('Skipped '.str_replace(base_path().'/', '', $path).' (exists; use --force to overwrite).');

            return;
        }

        File::ensureDirectoryExists(dirname($path));
        File::put($path, $contents);

        $this->components->task('Created '.str_replace(base_path().'/', '', $path));
    }

    private function classStub(string $class): string
    {
        $namespace = rtrim(CatalogComponent::screenNamespace(), '\\');

        return <<<PHP
        <?php

        namespace {$namespace};

        use App\NativeComponents\Components\ExampleScreen;

        class {$class} extends ExampleScreen
        {
            //
        }

        PHP;
    }

    private function viewStub(string $tag): string
    {
        return <<<BLADE
        @include('native.components.partials.top-bar')

        <ui:page>
            @include('native.components.partials.header')

            <ui:example title="Default">
                <ui:{$tag} />
            </ui:example>

            @include('native.components.partials.footer')
        </ui:page>

        BLADE;
    }
}
