<template>
    <component :is="layoutComponent">
      <div id="aboutUs" class="bg-white py-12">
        <div class="max-w-4xl mx-auto px-6 text-gray-800">
          <h1 class="text-4xl font-bold mb-6 text-cyan-500">Rólunk</h1>
          <p class="mb-4 text-lg">
            Üdvözlünk a <span class="font-semibold text-cyan-500">Tappancs</span>-nál – az online állateledel boltodban, ahol a kis kedvencek jóléte az első!
          </p>
          <p class="mb-4 text-lg">
            Célunk, hogy a lehető legjobb minőségű eledeleket és kiegészítőket biztosítsuk a háziállatok számára – legyen szó kutyákról, macskákról, rágcsálókról vagy madarakról.
            Csapatunk állatbarát szakértőkből áll, akik gondosan válogatják össze a kínálatot, hogy kedvenced egészséges és boldog legyen.
          </p>
          <p class="mb-4 text-lg">
            Gyors szállítás, egyszerű rendelés és mindig elérhető ügyfélszolgálat – nálunk ez az alap. Csatlakozz a PetPal családhoz, és tedd boldoggá kedvenced minden nap!
          </p>
          <p class="text-lg font-medium">
            Köszönjük, hogy minket választasz! 🐾
          </p>
        </div>
      </div>

      <div class="bg-gray-100 py-12">
        <div id="contact" class="max-w-4xl mx-auto px-6 text-gray-800">
          <h2 class="text-3xl font-bold mb-6 text-cyan-500">Kapcsolat</h2>
          <p class="mb-4 text-lg">Kérdésed van? Vedd fel velünk a kapcsolatot!</p>
          <ul class="space-y-3 text-lg">
            <li>
              <span class="font-semibold">Email:</span> <a href="mailto:info@petpal.hu" class="text-cyan-500 hover:underline">info@tappancs.hu</a>
            </li>
            <li>
              <span class="font-semibold">Telefon:</span> <a href="tel:+3612345678" class="text-cyan-500 hover:underline">+36 1 234 5678</a>
            </li>
            <li>
              <span class="font-semibold">Cím:</span> 1234 Budapest, Kisállat utca 12.
            </li>
            <li>
              <span class="font-semibold">Ügyfélszolgálat:</span> H–P: 9:00–17:00
            </li>
          </ul>
        </div>
      </div>

      <div id="helpMe" class="bg-white py-12">
        <div class="max-w-4xl mx-auto px-6 text-gray-800">
          <h2 class="text-3xl font-bold mb-6 text-cyan-500">Segítség</h2>
          <p class="mb-4 text-lg">Segítségre van szükséged? Regisztrálja kis kedvenceit, hogy egyszerübben tudjunk segítséget nyújtani.</p>
          <ul class="space-y-3 text-lg">
            <li>
              <span class="font-semibold">Email:</span> <a href="mailto:info@petpal.hu" class="text-cyan-500 hover:underline">info@tappancs.hu</a>
            </li>
            <li>
              <span class="font-semibold">Telefon:</span> <a href="tel:+3612345678" class="text-cyan-500 hover:underline">+36 1 234 5678</a>
            </li>
          </ul>
        </div>
      </div>
    </component>
  </template>

  <script setup>
  import { computed } from 'vue';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import GuestLayout from '@/Layouts/GuestLayout.vue';

  const props = defineProps({
    layout: Object,
    auth: Object,
  });

  const layoutComponent = computed(() => {
    return props.auth?.user ? AuthenticatedLayout : GuestLayout;
  });
  </script>
