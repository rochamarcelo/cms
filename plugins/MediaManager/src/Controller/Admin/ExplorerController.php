<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since    2.0.0
 * @author   Christopher Castro <chris@quickapps.es>
 * @link     http://www.quickappscms.org
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace MediaManager\Controller\Admin;

use MediaManager\Controller\AppController;

/**
 * File explorer.
 *
 */
class ExplorerController extends AppController
{

    /**
     * Renders elFinder's UI.
     *
     * @return void
     */
    public function index()
    {
        $this->title(__d('media_mnager', 'File Manager'));
        $this->Breadcrumb->push('/admin/media_manager/explorer');
    }

    /**
     * elFinder UI connector.
     *
     * @return void
     */
    public function connector()
    {
    }

    /**
     * Returns the given plugin's file within webroot directory.
     *
     * @return void
     */
    public function pluginFile()
    {
        if (!empty($this->request->query['file'])) {
            $path = $this->request->query['file'];
            $path = str_replace_once('#', '', $path);
            $file = str_replace('//', '/', SITE_ROOT . "/plugins/{$path}");
            if ((strpos($file, 'webroot') !== false || strpos($file, '.tmb') !== false) && file_exists($file)) {
                $this->response->file($file);
                return $this->response;
            }
        }
        die;
    }
}
