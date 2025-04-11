<template>
    <footer class="bg-black text-gray-800 py-16 border-t border-cyan-500">
      <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
        <div class="text-center md:text-left mb-4 md:mb-0">
          <h2 class="text-2xl font-bold text-cyan-500">Kutyavilág</h2>
          <p class="text-sm text-gray-600">© {{ currentYear }} Kutyavilág – Minden tappancsos jog fenntartva.</p>
        </div>

        <ul class="flex space-x-6 text-sm">
          <li><a href="#" class="text-white hover:text-gray-200">Rólunk</a></li>
          <li><a href="#" class="text-white hover:text-gray-200">Kapcsolat</a></li>
          <li><a href="#" class="text-white hover:text-gray-200">Adatvédelem</a></li>
        </ul>
      </div>
    </footer>
  </template>

  <script setup>
  const currentYear = new Date().getFullYear();
  </script>
