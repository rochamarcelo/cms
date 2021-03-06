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

use CMS\Event\EventDispatcher;

if (!function_exists('fieldsInfo')) {
    /**
     * Gets a collection of information of every registered field in the system, or
     * information for a particular field.
     *
     * Some fields may register themselves as hidden when they are intended to be
     * used exclusively by plugins. So users can not `attach` them to entities using
     * Field UI.
     *
     * ### Usage:
     *
     * ```php
     * $visibleOnly = fieldsInfo()->filter(function ($info) {
     *     return !$info['hidden'];
     * });
     * ```
     *
     * @param string|null $field Field for which get its information as an array, or
     *  null (default) to get all of them as a collection. e.g.
     *  `Field\Field\TextField`
     * @return \Cake\Collection\Collection|array A collection of fields information
     */
    function fieldsInfo($field = null)
    {
        $fields = [];
        $plugins = plugin()->filter(function ($plugin) {
            return $plugin->status;
        });

        foreach ($plugins as $plugin) {
            foreach ($plugin->fields as $className) {
                if (class_exists($className)) {
                    $handler = new $className();
                    $result = array_merge([
                        'type' => 'varchar',
                        'name' => null,
                        'description' => null,
                        'hidden' => false,
                        'handler' => $className,
                        'maxInstances' => 0,
                        'searchable' => true,
                    ], (array)$handler->info());
                    $fields[$className] = $result;
                }
            }
        }

        if ($field === null) {
            return collection(array_values($fields));
        }

        if (isset($fields[$field])) {
            return $fields[$field];
        }

        throw new \Exception(__d('field', 'The field handler "{0}" was not found.', $field));
    }
}
