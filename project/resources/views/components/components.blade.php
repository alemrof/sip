<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
Baza danych
</div>

<!-- Nav Item - sieci sklepów -->
<li class="nav-item">
    <a class="nav-link" href="{{route('companies.index')}}">
      <i class="fas fa-tags"></i>
      <span>Sieci sklepów</span>
    </a>
</li>

<!-- Nav Item - składy budowlane -->
<li class="nav-item">
  <a class="nav-link" href="{{route('warehouses.index')}}">
    <i class="fas fa-pallet"></i>
    <span>Składy budowlane</span>
  </a>
</li>

<!-- Nav Item - kategorie produktów -->
<li class="nav-item">
  <a class="nav-link" href="{{route('categories.index')}}">
    <i class="fas fa-archive"></i>
    <span>Kategorie produktów</span>
  </a>
</li>

<!-- Nav Item - produkty -->
<li class="nav-item">
  <a class="nav-link" href="{{route('products.index')}}">
    <i class="fas fa-shopping-cart"></i>
    <span>Produkty</span>
  </a>
</li>

<!-- Nav Item - użytkownicy -->
@auth
  @if (auth()->user()->isAdmin())
  <li class="nav-item">
    <a class="nav-link" href="{{route('users.index')}}">
      <i class="fas fa-users"></i>
      <span>Użytkownicy</span>
    </a>
  </li>    
  @endif
@endauth


<!-- Divider -->
<hr class="sidebar-divider">