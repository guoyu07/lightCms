<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017-10-18
 * Time: 18:58
 */

namespace App\Http\Controllers;

use Inhere\Library\Utils\LiteLogger;
use LightCms\Web\BaseController;

/**
 * class HomeController
 */
class HomeController extends BaseController
{
    public function indexAction()
    {
        $content = 'hello, welcome!! this is ' . __METHOD__;
//de(\Sys::get('config')->all());

        d(\Sys::get('logger'));

        \Sys::get('logger')->info('a message test');
        \Sys::get('logger')->notice('a notice test');
        \Sys::get('logger')->flush();

        de(\Sys::get('logger'));

        return $this->renderContent($content);
    }

    public function testAction()
    {

        $lgr = LiteLogger::make([
            'name' => 'test',
            'splitType' => 'hour',
            'basePath' => BASE_PATH . '/user/tmp',
        ]);

        $lgr->trace('a traced message');
        $lgr->info('a info message');
        var_dump($lgr);

        $lgr->flush();

        echo 'hello';
    }

    public function configAction()
    {
        Micro::$app->output->formatJson([
            'phpVersion' => PHP_VERSION,
            'env' => Micro::$app->config('env'),
            'debug' => Micro::$app->isDebug(),
        ]);
    }

    public function json()
    {
        \Sys::trace('test info');

        Micro::$app->output->json([
            'code' => 0,
            'msg' => 'successful!',
            'data' => [
                'name' => 'value',
            ]
        ]);
    }
}
