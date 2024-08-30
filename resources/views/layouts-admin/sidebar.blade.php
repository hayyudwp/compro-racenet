  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      

      <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'home') ? '' : 'collapsed' }}" data-bs-target="#home-nav" data-bs-toggle="collapse" href="#" aria-expanded="false">
          <i class="bi bi-house-door-fill"></i><span>Home</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="home-nav"class="nav-content collapse {{ (request()->segment(2) == 'home') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('homecontent.index') }}" class="{{ (request()->segment(3) == 'content') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Contect</span>
            </a>
          </li>
          <li>
            <a href="{{ route('pricelist.index') }}" class="{{ (request()->segment(3) == 'pricelist') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Price List</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'product') ? '' : 'collapsed' }}" data-bs-target="#product-nav" data-bs-toggle="collapse" href="#" aria-expanded="false">
          <i class="bi bi-hdd-rack-fill"></i><span>Product</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="product-nav"class="nav-content collapse {{ (request()->segment(2) == 'product') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('broadband.index') }}" class="{{ (request()->segment(3) == 'broadband-internet') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Broadband Internet</span>
            </a>
          </li>
          <li>
            <a href="{{ route('dedicated.index') }}" class="{{ (request()->segment(3) == 'dedicated-internet') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Dedicated Internet</span>
            </a>
          </li>
          <li>
            <a href="{{ route('hosting.index') }}" class="{{ (request()->segment(3) == 'hosting') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Cloud Hosting</span>
            </a>
          </li>
          <li>
            <a href="{{ route('colocation.index') }}" class="{{ (request()->segment(3) == 'colocation') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Colocation Server</span>
            </a>
          </li>
          <li>
            <a href="{{ route('manage-service.index') }}" class="{{ (request()->segment(3) == 'manage-service-solution') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Manage Service</span>
            </a>
          </li>
          <li>
            <a href="{{ route('it-solution.index') }}" class="{{ (request()->segment(3) == 'it-solution') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>IT Solution</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'about') ? '' : 'collapsed' }}" data-bs-target="#about-nav" data-bs-toggle="collapse" href="#" aria-expanded="false">
          <i class="bi bi-file-earmark-person-fill"></i><span>About</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="about-nav"class="nav-content collapse {{ (request()->segment(2) == 'about') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('content.index') }}" class="{{ (request()->segment(3) == 'content') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Contect</span>
            </a>
          </li>
          <li>
            <a href="{{ route('about.index') }}" class="{{ (request()->segment(3) == 'about-list') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>About List</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'header') ? '' : 'collapsed' }}" href="{{ route('header.index') }}">
          <i class="bi bi-menu-button-wide-fill"></i>
          <span>Header</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'footer') ? '' : 'collapsed' }}" data-bs-target="#footer-nav" data-bs-toggle="collapse" href="#" aria-expanded="false">
          <i class="bi bi-person-rolodex"></i><span>Footer</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="footer-nav"class="nav-content collapse {{ (request()->segment(2) == 'footer') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('footer-desc.index') }}" class="{{ (request()->segment(3) == 'footer-description') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Description</span>
            </a>
          </li>
          <li>
            <a href="{{ route('branch.index') }}" class="{{ (request()->segment(3) == 'branch') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Branch</span>
            </a>
          </li>
          <li>
            <a href="{{ route('contact.index') }}" class="{{ (request()->segment(3) == 'contact') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Contact</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'coverage') ? '' : 'collapsed' }}" href="{{ route('coverage.index') }}">
          <i class="bi bi-map-fill"></i>
          <span>Coverage</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (request()->segment(2) == 'help') ? '' : 'collapsed' }}" href="{{ route('help.index') }}">
          <i class="bi bi-info-square-fill"></i>
          <span>Help</span>
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