@props(['route', 'icon', 'label'])

<a href="{{ route($route) }}" 
   class="d-flex align-items-center text-decoration-none p-3 rounded 
          {{ request()->routeIs($route) ? 'bg-rose text-white' : 'bg-light text-dark hover-bg-light' }}">
   <i class="{{ $icon }} fs-5 me-3"></i>
   <span>{{ $label }}</span>
</a>
