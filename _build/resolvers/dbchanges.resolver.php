<?php
/**
* defaultcomponent
*
* Copyright 2010-11 by SCHERP Ontwikkeling <info@scherpontwikkeling.nl>
*
* This file is part of defaultComponent, a simple commenting component for MODx Revolution.
*
* defaultComponent is free software; you can redistribute it and/or modify it under the
* terms of the GNU General Public License as published by the Free Software
* Foundation; either version 2 of the License, or (at your option) any later
* version.
*
* defaultComponent is distributed in the hope that it will be useful, but WITHOUT ANY
* WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
* A PARTICULAR PURPOSE. See the GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License along with
* defaultComponent; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
* Suite 330, Boston, MA 02111-1307 USA
*
* @package defaultcomponent
*/
/**
* Resolves db changes
*
* @package defaultcomponent
* @subpackage build
*/

/*

// Example from Quip by Shaun

if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('defaultcomponent.core_path',null,$modx->getOption('core_path').'components/defaultcomponent/').'model/';
            $modx->addPackage('defaultcomponent',$modelPath);

            $manager = $modx->getManager();

            $manager->addField('defaultcomponentComment','name');
            $manager->addField('defaultcomponentComment','email');
            $manager->addField('defaultcomponentComment','website');

            // alter approved field 
            $manager->alterField('defaultcomponentComment','approved');

            // add resource mapping changes 
            $manager->addField('defaultcomponentComment','resource');
            $manager->addField('defaultcomponentComment','idprefix');
            $manager->addField('defaultcomponentComment','existing_params');
            $manager->addIndex('defaultcomponentComment','resource');

            //	add threaded changes 
            $manager->addField('defaultcomponentComment','ip',array('after' => 'website'));
            $manager->addField('defaultcomponentComment','rank',array('after' => 'parent'));

            // add approval/deleted changes 
            $manager->addField('defaultcomponentComment','approvedby',array('after' => 'approvedon'));
            $manager->addField('defaultcomponentComment','deleted',array('after' => 'ip'));
            $manager->addField('defaultcomponentComment','deletedon',array('after' => 'deleted'));
            $manager->addField('defaultcomponentComment','deletedby',array('after' => 'deletedon'));
            $manager->addIndex('defaultcomponentComment','approvedby');
            $manager->addIndex('defaultcomponentComment','deleted');
            $manager->addIndex('defaultcomponentComment','deletedby');

            // add call_params to defaultcomponentThread 
            $manager->addField('defaultcomponentThread','defaultcomponent_call_params');
            $manager->addField('defaultcomponentThread','defaultcomponentreply_call_params');

            // create thread objects for comments if they dont exist 
            $c = $modx->newQuery('defaultcomponentComment');
            $c->sortby('createdon','DESC');
            $comments = $modx->getCollection('defaultcomponentComment',$c);
            foreach ($comments as $comment) {
                $thread = $comment->getOne('Thread');
                if (empty($thread)) {
                    $thread = $modx->newObject('defaultcomponentThread');
                    $thread->set('name',$comment->get('thread'));
                    $thread->set('idprefix',$comment->get('idprefix'));
                    $thread->set('existing_params',$comment->get('existing_params'));
                    $thread->set('resource',$comment->get('resource'));
                    $thread->set('createdon',$comment->get('createdon'));
                    $thread->set('moderator_group','Administrator');
                    $thread->save();
                }
                unset($thread);
            }
            unset($comments,$comment,$c);

            break;
    }
}
*/
return true;