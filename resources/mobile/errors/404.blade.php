<!DOCTYPE html>
<html lang="en-US">
@include('head')  

<body id="page-top">
    <div class="m-scene" id="main"> <!-- Main Container -->

      <!-- Page Content -->
      <div id="content" class="page-404 grey-blue">

        <!-- Main Content -->
        <div class="animated fadeinup">
          <div class="valign-wrapper fullscreen">
            <div class="valign">
              <div class="row">
                <div class="col s12 center-align">
                  <h1 class="title">404</h1>
                </div>
                <div class="col s12 center-align p-20">
                  <div class="card-panel animated fadein delay-2">
                    <h2>Oops!</h2>
                    <span>The page you're looking for was not found.<br>
                      <a class="accent-text" href="<?=url()?>"><i class="ion-android-home"></i></a>
                    </span>
                  </div>
                  <nav class="transparent no-shadow animated fadeinright delay-3">
                    <div class="nav-wrapper">
                      <!-- <form>
                        <div class="input-field">
                          <input id="search" type="search" placeholder="Search..." required>
                          <label for="search"><i class="ion-android-search"></i></label>
                          <i class="ion-android-close"></i>
                        </div>
                      </form> -->
                    </div>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- End of Main Contents -->

         
      </div> <!-- End of Page Content -->

    </div> <!-- End of Page Container -->

    @include('bottom')  
  </body>



</body>
</html>