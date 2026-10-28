<?php
$page_title = 'About Us – Solemates';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-gray-900 to-gray-800 h-80 flex items-center overflow-hidden">
  <div class="absolute inset-0">
    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixlib=rb-4.1.0&q=80&w=1080" alt="Hero" class="w-full h-full object-cover opacity-30">
  </div>
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center w-full">
    <h1 class="text-5xl font-extrabold text-white">About Solemates</h1>
    <p class="mt-4 text-xl text-gray-300">Stepping into your perfect sole since 2024</p>
  </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-20">
    <div>
      <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Story</h2>
      <p class="text-gray-700 text-lg leading-relaxed mb-4">
       Masarap ba ang ginagawa ni ferdinand sayo? Hindi naman masarap ang ginagawa sayo, hindi namaan ga tirik mga mata unat gid ang leeg, mga paa.. HEH  Grabe, opoo... Kaya lumakas ako e, kulang pa nga e.. Punuin ko yang tangke mo.
      </p>
      <p class="text-gray-700 text-lg leading-relaxed">
        Love youuu.. Dapat nag dala ka pa ng polbo e,, May polbo naman ako nung time na yon ehh... Bat di ka nag polbo?? Himud himudin ko pa sana yan ay.. Himud himudin ko pa sana... Makati daw ako, pero ang sarap di ko makalimutan.. Bakit?? sino bang aayaw???
      </p>
    </div>
    <div>
      <img src="https://images.unsplash.com/photo-1552346154-21d32810aba3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Our Story" class="rounded-lg shadow-lg">
    </div>
  </div>

  <!-- Values Section -->
  <div class="mb-20">
    <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Our Values</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="text-center p-8 border border-gray-200 rounded-lg hover:shadow-lg transition-shadow">
        <div class="text-4xl mb-4">🎯</div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Quality First</h3>
        <p class="text-gray-700">We only stock premium footwear from trusted brands, ensuring every step is comfortable and stylish.</p>
      </div>
      <div class="text-center p-8 border border-gray-200 rounded-lg hover:shadow-lg transition-shadow">
        <div class="text-4xl mb-4">🌍</div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Global Curation</h3>
        <p class="text-gray-700">Our collection spans the globe, bringing you the best footwear from international designers and brands.</p>
      </div>
      <div class="text-center p-8 border border-gray-200 rounded-lg hover:shadow-lg transition-shadow">
        <div class="text-4xl mb-4">💝</div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Customer Love</h3>
        <p class="text-gray-700">Your satisfaction is our priority. We're committed to exceptional service and support.</p>
      </div>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="bg-black text-white rounded-lg p-12 text-center">
    <h2 class="text-3xl font-bold mb-4">Ready to Find Your Perfect Sole?</h2>
    <p class="text-gray-300 mb-6 text-lg">Explore our full collection and discover footwear that speaks to your style.</p>
    <a href="<?= BASE_URL ?>/catalog.php" class="inline-block px-8 py-3 bg-white text-black font-bold rounded-md hover:bg-gray-100 transition-colors">Shop Now</a>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php';
