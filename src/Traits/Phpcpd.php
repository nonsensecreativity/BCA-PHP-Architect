<?php
/**
 * Brodkin CyberArts Website
 *
 * @package    robo
 * @subpackage bca/architect
 * @author     Brodkin CyberArts <info@brodkinca.com>
 * @copyright  2015 Brodkin CyberArts
 */

namespace BCA\Architect\Traits;

use \BCA\Architect\Architect;
use \BCA\Architect\Config;

trait Phpcpd
{
    /**
     * Run PHPCPD.
     * @return Robo\Result
     */
    public function taskPhpcpd()
    {
        Config::setDefault('pathsPhpcpd', array_merge(
            (array) Config::get('pathsSrc'),
            (array) Config::get('pathsTests')
        ));

        $exec = $this->taskExec(Config::get('pathComposerBin').'/phpcpd')
            ->option('fuzzy')
            ->arg(Config::get('pathsPhpcpd'));

        // Enable logging in CI.
        if ((bool) getenv('CI')) {
            $exec->option('log-pmd', Config::get('pathBuildDir').'/logs/phpcpd.xml');
        }

        return $exec->run();
    }

    /**
     * Boot phpcpd trait.
     * @return void
     */
    protected function bootPhpcpd()
    {
        // Set weights.
        Architect::setWeight('taskPhpcpd', 40);
    }
}
