

    <div class="c-wrapper">
      <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
<!--        --><?php
//            use App\MenuBuilder\FreelyPositionedMenus;
//            if(isset($appMenus['top menu'])){
//                FreelyPositionedMenus::render( $appMenus['top menu'] , 'c-header-', 'd-md-down-none');
//            }
//        ?>
        <ul class="c-header-nav ml-auto mr-4">
          <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <div class="c-avatar"><img class="c-avatar-img" src="{{ url('/assets/img/avatars/6.jpg') }}" alt="user@email.com"></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
              <div class="dropdown-header bg-light py-2"><strong>Account</strong></div><a class="dropdown-item" href="/profile">
                    <i class="fas fa-user" style="margin-right: 15px"></i>  Profile</a><a class="dropdown-item" href="/change-password">
                    <i class="fas fa-lock" style="margin-right: 15px"></i> Change Password</a><a class="dropdown-item" href="#">
                    <i class="fas fa-sign-out-alt"></i> <form action="{{ url('/logout') }}" method="POST"> @csrf <button type="submit" class="btn btn-ghost-dark btn-block">Logout</button></form></a>
            </div>
          </li>
        </ul>
        <div class="c-subheader px-3">
          <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <?php $segments = ''; ?>
            @for($i = 1; $i <= count(Request::segments()); $i++)
                <?php $segments .= '/'. \App\Helpers\CommonHelper::removeDash(Request::segment($i)); ?>
                @if($i < count(Request::segments()))
                    <li class="breadcrumb-item">{{ \App\Helpers\CommonHelper::removeDash(Request::segment($i)) }}</li>
                @else
                    <li class="breadcrumb-item active">{{ \App\Helpers\CommonHelper::removeDash(Request::segment($i),Request::segments()) }}</li>
                @endif
            @endfor
          </ol>
        </div>
    </header>
