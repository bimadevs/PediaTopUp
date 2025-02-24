<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\Commands\Utilities;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Commands\Utilities\Routes\FilterCollector;

/**
 * Check filters for a route.
 */
class FilterCheck extends BaseCommand
{
    /**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group = 'CodeIgniter';

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name = 'filter:check';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Check filters for a route.';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'filter:check <HTTP method> <route>';

    /**
     * the Command's Arguments
     *
     * @var array<string, string>
     */
    protected $arguments = [
        'method' => 'The HTTP method. GET, POST, PUT, etc.',
        'route'  => 'The route (URI path) to check filters.',
    ];

    /**
     * the Command's Options
     *
     * @var array<string, string>
     */
    protected $options = [];

    /**
     * @return int exit code
     */
    public function run(array $params)
    {
        $tbody = [];
        if (! isset($params[0], $params[1])) {
            CLI::error('You must specify a HTTP verb and a route.');
            CLI::write('  Usage: ' . $this->usage);
            CLI::write('Example: filter:check GET /');
            CLI::write('         filter:check PUT products/1');

            return EXIT_ERROR;
        }

        $method = $params[0];
        $route  = $params[1];

        // Load Routes
        service('routes')->loadRoutes();

        $filterCollector = new FilterCollector();

        $filters = $filterCollector->get($method, $route);

        // PageNotFoundException
        if ($filters['before'] === ['<unknown>']) {
            CLI::error(
                "Can't find a route: " .
                CLI::color(
                    '"' . strtoupper($method) . ' ' . $route . '"',
                    'black',
                    'light_gray',
                ),
            );

            return EXIT_ERROR;
        }

        $filters = $this->addRequiredFilters($filterCollector, $filters);

        $tbody[] = [
            strtoupper($method),
            $route,
            implode(' ', $filters['before']),
            implode(' ', $filters['after']),
        ];

        $thead = [
            'Method',
            'Route',
            'Before Filters',
            'After Filters',
        ];

        CLI::table($tbody, $thead);

        return EXIT_SUCCESS;
    }

    private function addRequiredFilters(FilterCollector $filterCollector, array $filters): array
    {
        $output = [];

        $required = $filterCollector->getRequiredFilters();

        $colored = [];

        foreach ($required['before'] as $filter) {
            $filter    = CLI::color($filter, 'yellow');
            $colored[] = $filter;
        }
        $output['before'] = array_merge($colored, $filters['before']);

        $colored = [];

        foreach ($required['after'] as $filter) {
            $filter    = CLI::color($filter, 'yellow');
            $colored[] = $filter;
        }
        $output['after'] = array_merge($filters['after'], $colored);

        return $output;
    }
}
