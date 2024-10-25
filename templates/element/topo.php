<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2 px-4 mb-4 border-bottom bg-white">
  <div class="col-md-3 mb-2 mb-md-0">
    <a href="<?= $this->Url->build(['controller' => 'playlists', 'action' => 'index']) ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
      <?php echo $this->Html->image('logo.png', ['alt' => 'Logo', 'width' => '80']) ?>
      <span class="fs-4">SectoTeca</span>
    </a>
  </div>
  
  <ul class="nav col-auto col-md-auto mb-2 justify-content-center mb-md-0">
    <li><a href="<?php echo $this->Url->build(['controller' => 'playlists', 'action' => 'index']); ?>" class="nav-link px-2 mx-2 <?php echo $linkUrl == '/Playlists/index' ? 'text-primary active btn btn-2 btn-primary text-white btn-block px-4 py-2 me-3 text-nowrap' : 'text-secondary' ?>" style="font-size: 14px;">Playlists</a></li>
    <li><a href="<?php echo $this->Url->build(['controller' => 'conteudos', 'action' => 'index']); ?>" class="nav-link px-2 mx-2 <?php echo $linkUrl == '/Conteudos/index' ? 'text-primary active btn btn-2 btn-primary text-white btn-block px-4 py-2 me-3 text-nowrap' : 'text-secondary' ?>" style="font-size: 14px;">Conteúdos</a></li>
  </ul>
  <div class="col-md-3 text-end">
  </div>
</header>