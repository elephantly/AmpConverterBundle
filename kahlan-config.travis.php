<?php

use Kahlan\Filter\Filter;
use Kahlan\Reporter\Coverage;
use Kahlan\Reporter\Coverage\Driver\Xdebug;
use Kahlan\Reporter\Coverage\Exporter\Coveralls;
use Kahlan\Reporter\Coverage\Exporter\CodeClimate;

$commandLine = $this->commandLine();
$commandLine->option('coverage', 'default', 3);
$commandLine->option('src', 'default', array('./Client', './Converter', './DependencyInjection'));

Filter::register('kahlan.coverage', function($chain) {
    if (!extension_loaded('xdebug')) {
        return;
    }
    $reporters = $this->reporters();
    $coverage = new Coverage([
        'verbosity' => $this->commandLine()->get('coverage'),
        'driver'    => new Xdebug(),
        'path'      => $this->commandLine()->get('src'),
        'colors'    => !$this->commandLine()->get('no-colors')
    ]);
    $reporters->add('coverage', $coverage);
});
Filter::apply($this, 'coverage', 'kahlan.coverage');
Filter::register('kahlan.coverage-exporter', function($chain) {
    $reporter = $this->reporters()->get('coverage');
    if (!$reporter) {
        return;
    }
    // Coveralls::write([
    //     'collector'      => $reporter,
    //     'file'           => 'coveralls.json',
    //     'service_name'   => 'travis-ci',
    //     'service_job_id' => getenv('TRAVIS_JOB_ID') ?: null
    // ]);
    CodeClimate::write([
        'collector'  => $reporter,
        'file'       => 'codeclimate.json',
        'branch'     => getenv('TRAVIS_BRANCH') ?: null,
        'repo_token' => 'f247b0d7edc57539b62b4be98713f14f858c80b62df7e894db65e1b4fe705027'
    ]);
    return $chain->next();
});
Filter::apply($this, 'reporting', 'kahlan.coverage-exporter');
