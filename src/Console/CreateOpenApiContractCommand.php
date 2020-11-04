<?php

namespace Primitive\Console;

use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

class CreateOpenApiContractCommand extends Command
{
    protected $signature = 'openapi:create';

    protected $description = 'Scaffold an OpenAPI Contract';

    public function handle()
    {
        $this->info('Creating your OpenAPI Contract');

        if (!file_exists(config_path('openapi.php'))) {
            $publishConfig = $this->ask('You need to publish the config first. Would you like to do that?', 'yes');

            if ($publishConfig) {
                $this->call('vendor:publish', ['--provider' => 'Primitive\OpenApiServiceProvider']);
                $this->call('config:cache');
            }
        }

        $oasVersion = $this->ask('What version of OpenAPI are you using?', '3.0.3');

        $appName = $this->ask('What app are you working on?');

        $developerName = $this->ask('What is your name? Can be your name, or a company/org name.');
        $developerEmail = $this->ask('What is your email? Can be a specific email like jon@gmail.com or developers@company.com.');
        $developerUrl = $this->ask('What is the url for the project? Can be a Github/Gitlab link, site url, company url etc.');

        $appVersion = $this->ask('What version of the application are you on?', '0.1.0');

        $appDescription = $this->ask('What is a description of the app?');

        $directoryName = $this->ask('Where do you want the spec file to live? The default is set in the config/openapi.php');

        $this->info('The contract is generated with empty fields for you to populate as you develop. If you have questions about the spec here is the official guide: https://github.com/OAI/OpenAPI-Specification/blob/master/versions/3.0.3.md');

        $data = [
            'openapi' => $oasVersion,
            'info' => [
                'title' => (string) $appName,
                'version' => $appVersion,
                'description' => $appDescription,
                'contact' => [
                    'name' => $developerName,
                    'email' => $developerEmail,
                    'url' => $developerUrl
                ]
            ],
            'servers' => [
                [
                    'url' => config('openapi.url'),
                    'description' => config('openapi.url_description')
                ],
            ],
            'tags' => null,
            'paths' => null,
            'components' => [
                'schemas' => null,
                'responses' =>  null,
                'headers' => null,
                'parameters' => null,
                'links' => null,
                'examples' => null
            ]
        ];

        $contract = Yaml::dump($data);

        if ($directoryName) {
            $this->info(sprintf('Creating directory at: %s', sprintf('./%s', $directoryName)));


            mkdir(sprintf('./%s', $directoryName));

            file_put_contents(sprintf('./%s/openapi.yml', $directoryName), $contract);


            $this->info(sprintf('Contract created at: ./%s/openapi.yml', $directoryName));
        } else {
            $this->info(sprintf('Creating directory at: %s', sprintf('./%s', config('openapi.contract_directory'))));

            mkdir(sprintf('./%s', config('openapi.contract_directory')));

            file_put_contents(sprintf('./%s/openapi.yml', config('openapi.contract_directory')), $contract);

            $this->info(sprintf('Contract created at: ./%s/openapi.yml', config('openapi.contract_directory')));
        }

        $this->info('It\'s dangerous to go alone. Take this: https://stoplight.io/studio/');

        $installSpectral = $this->confirm('Do you want to install Stoplight Spectral so you can lint your OpenAPI contract as you build it?');

        if ($installSpectral) {
            $this->info('Installing Spectral');
            exec('npm install -g @stoplight/spectral');
            $this->newLine();
            $this->info('To call Spectral, run this command:');
            $this->line(sprintf('spectral lint %s/openapi.yml', config('openapi.directory')));
        }

        $this->newLine();
        $this->info('All finished. Happy coding!');
    }
}