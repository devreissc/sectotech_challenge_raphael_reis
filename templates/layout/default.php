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

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <?=  $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>

    <?= $this->fetch('script') ?>
</head>
<body class="body-admin">
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
		<div class="bg-dark border-right" id="sidebar-wrapper">
			<?php echo $this->element('sidebar') ?>
		</div>
        
        <div id="page-content-wrapper">
            <?= $this->Flash->render() ?>
            <?php echo $this->element('topo'); ?>
            <div class="container-fluid  px-4 py-3">
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<style>
    #page-content-wrapper {
	  min-width: 0;
	  width: 100%;
	  background-color: #E2E5E9;
	}

    .body-admin #wrapper {
  overflow-x: hidden;
}
.body-admin #sidebar-wrapper {
  width: 260px;
  min-height: 100vh;
  transition: margin 0.35s ease-out;
}
.body-admin #sidebar-wrapper .logo-aberto {
  display: block;
}
.body-admin #sidebar-wrapper .logo-fechado {
  display: none;
}
.body-admin #sidebar-wrapper.reduzido {
  width: auto;
}
.body-admin #sidebar-wrapper.reduzido .item-label {
  display: none;
}
.body-admin #sidebar-wrapper.reduzido .logo-fechado {
  display: block;
}
.body-admin #sidebar-wrapper.reduzido .logo-aberto {
  display: none;
}
.body-admin #sidebar-wrapper.reduzido .nav-item {
  text-align: center;
}
.body-admin #sidebar-wrapper .nav-pills .nav-link {
  border-radius: 0 !important;
}
.body-admin #sidebar-wrapper .nav-pills .nav-link.active {
  background-color: #0d5ce1;
}
.body-admin #page-content-wrapper {
  min-width: 0;
  width: 100%;
  background-color: #E2E5E9;
}

@media (max-width: 576px) {
  .logo-aberto {
    width: 130px;
  }
  #sidebar-wrapper {
    display: none;
  }
  #sidebar-wrapper.reduzido {
    display: block;
  }
  .carteira-box-info {
    padding-left: 0 !important;
    padding-right: 0 !important;
  }
}
</style>