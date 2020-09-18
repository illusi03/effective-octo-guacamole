<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include("layouts.components.head")

<body>
  <div id="app">
    @include("layouts.components.nav")

    <main class="py-4 my-style">
      @yield('content')
    </main>

  </div>
  @include('sweetalert::alert')
  @stack("scripts.footer")
</body>

</html>