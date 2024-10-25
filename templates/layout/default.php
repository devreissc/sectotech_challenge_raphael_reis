<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$description = 'SectoTeca';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <title>
        <?= $description ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon', 'img/logo.png'); ?>

    <?= $this->Html->css(
        [
            'home',
            'normalize.min', 
            'milligram.min',
            'fonts', 
            'cake',
            'bootstrap5/css/bootstrap.min',
            'bootstrap5/css/bootstrap-reboot',
            'bootstrap5/css/bootstrap-utilities',
        ]
    ) ?>

    <?= $this->Html->script(
        [
            'bootstrap5/js/bootstrap.bundle',
            'bootstrap5/js/bootstrap.min',
            'global'
        ]
    ) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/4f047c8f43.js" crossorigin="anonymous"></script>
    
    <?=  $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>    
</head>
<body class="body-admin">
    <div class="d-flex" id="wrapper">
        <div id="page-content-wrapper">
            <?php echo $this->element('topo'); ?>
            <?php echo $this->Flash->render(); ?>
            <div class="container-fluid px-4 py-3" style="min-height:92vh">
                <?php echo $this->fetch('content')?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
</body>
</html>