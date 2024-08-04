  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      

      <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'homecontent' || request()->segment(2) == 'pricelist') ? '' : 'collapsed' }}" data-bs-target="#home-nav" data-bs-toggle="collapse" href="#" aria-expanded="false">
          <i class="bi bi-house-door-fill"></i><span>Home</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="home-nav"class="nav-content collapse {{ (request()->segment(2) == 'homecontent' || request()->segment(2) == 'pricelist') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('homecontent.index') }}" class="{{ (request()->segment(2) == 'homecontent') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Contect</span>
            </a>
          </li>
          <li>
            <a href="{{ route('pricelist.index') }}" class="{{ (request()->segment(2) == 'pricelist') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Price List</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'content' || request()->segment(2) == 'about') ? '' : 'collapsed' }}" data-bs-target="#about-nav" data-bs-toggle="collapse" href="#" aria-expanded="false">
          <i class="bi bi-file-earmark-person-fill"></i><span>About</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="about-nav"class="nav-content collapse {{ (request()->segment(2) == 'content' || request()->segment(2) == 'about') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('content.index') }}" class="{{ (request()->segment(2) == 'content') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Contect</span>
            </a>
          </li>
          <li>
            <a href="{{ route('about.index') }}" class="{{ (request()->segment(2) == 'about') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>About List</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'header') ? '' : 'collapsed' }}" href="{{ route('header.index') }}">
          <i class="bi bi-card-heading"></i>
          <span>Header</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'help') ? '' : 'collapsed' }}" href="{{ route('help.index') }}">
          <i class="bi bi-info-square-fill"></i>
          <span>Help</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'coverage') ? '' : 'collapsed' }}" href="{{ route('coverage.index') }}">
          <i class="bi bi-map-fill"></i>
          <span>Coverage</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'sosmed') ? '' : 'collapsed' }}" href="{{ route('sosmed.index') }}">
          <i class="bi bi-collection-fill"></i>
          <span>Social Media</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'suggest') ? '' : 'collapsed' }}" href="{{ route('suggest.index') }}">
          <i class="bi bi-chat-left-text-fill"></i>
          <span>Suggest</span>
        </a>
      </li>
    </ul>

  </aside><!-- End Sidebar-->