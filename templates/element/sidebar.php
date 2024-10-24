<div class="row justify-content-between h-100 barra-lateral ">
    <div class="col-12">
        <nav class="h-100 position-relative ">
            <div class="d-flex flex-column ">
                <div class="d-flex align-items-center justify-content-center mb-3 mt-3">
                    <?= $this->Html->image('logo.png', ['alt' => 'Logo', 'width' => '100', 'height' => '100']) ?>
                </div>
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" aria-current="page">
                        Playlists
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link active" aria-current="page">
                        Playlists
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link active" aria-current="page">
                        Playlists
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link active" aria-current="page">
                        Playlists
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){

    var statusMenu = null;
    var Sidebar = {
      init: function(){
        Sidebar.verificaMenu();
        Sidebar.toggle();
      },
      verificaMenu: function(){
        
        var status = window.localStorage.getItem('');
        
        if(status == 'reduzido'){
          window.localStorage.setItem('status_menu_admin', 'reduzido');
          $("#sidebar-wrapper").addClass('reduzido');
        }else{

          window.localStorage.setItem('status_menu_admin', 'aberto');
          $("#sidebar-wrapper").removeClass('reduzido');
          
        }

        statusMenu = status;

      },
      toggle: function(){
        $("#menu-toggle").unbind().click(function (e) {
            e.preventDefault();

            if($("#sidebar-wrapper").hasClass('reduzido')){
              window.localStorage.setItem('status_menu_admin', 'aberto');
            }else{
              window.localStorage.setItem('status_menu_admin', 'reduzido');
            }
            $("#sidebar-wrapper").toggleClass("reduzido");
        });
      }
    }

    Sidebar.init();

  });
</script>