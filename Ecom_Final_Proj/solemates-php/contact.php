<?php
$page_title = 'Contact Us – Solemates';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-gray-900 to-gray-800 h-80 flex items-center overflow-hidden">
  <div class="absolute inset-0">
    <img src="https://images.unsplash.com/photo-1552346154-21d32810aba3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1080" alt="Hero" class="w-full h-full object-cover opacity-30">
  </div>
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center w-full">
    <h1 class="text-5xl font-extrabold text-white">Get in Touch</h1>
    <p class="mt-4 text-xl text-gray-300">We're here to help and answer any question you might have</p>
  </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
    <!-- Email Card -->
    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-100 hover:shadow-lg transition-shadow text-center">
      <div class="bg-black text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
      </div>
      <h3 class="text-2xl font-bold text-gray-900 mb-2">Email</h3>
      <p class="text-gray-600 mb-4">We typically respond within 24 hours</p>
      <a href="mailto:support@solemates.ph" class="text-black font-bold hover:underline">support@solemates.ph</a>
    </div>

    <!-- Phone Card -->
    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-100 hover:shadow-lg transition-shadow text-center">
      <div class="bg-black text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
        </svg>
      </div>
      <h3 class="text-2xl font-bold text-gray-900 mb-2">Phone</h3>
      <p class="text-gray-600 mb-4">Mon-Fri, 9am - 6pm PHT</p>
      <a href="tel:+63291234567" class="text-black font-bold hover:underline">+63 (2) 9123-4567</a>
    </div>

    <!-- Address Card -->
    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-100 hover:shadow-lg transition-shadow text-center">
      <div class="bg-black text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
      </div>
      <h3 class="text-2xl font-bold text-gray-900 mb-2">Visit Us</h3>
      <p class="text-gray-600 mb-4">Stop by our flagship store</p>
      <address class="text-black font-bold not-italic">P. Paredes St<br>Manila City</address>
    </div>
  </div>

  <!-- FAQ Section -->
  <div class="bg-gray-50 rounded-lg p-12 mb-20">
    <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Frequently Asked Questions</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div>
        <h3 class="font-bold text-lg text-gray-900 mb-2">What's your return policy?</h3>
        <p class="text-gray-700">We offer 30 days for returns on unworn items with original packaging intact.</p>
      </div>
      <div>
        <h3 class="font-bold text-lg text-gray-900 mb-2">How long does shipping take?</h3>
        <p class="text-gray-700">Standard shipping takes 5-7 business days. Express shipping available for ₱80.</p>
      </div>
      <div>
        <h3 class="font-bold text-lg text-gray-900 mb-2">Do you offer international shipping?</h3>
        <p class="text-gray-700">We ship nationwide within the Philippines. International shipping coming soon!</p>
      </div>
      <div>
        <h3 class="font-bold text-lg text-gray-900 mb-2">How do I track my order?</h3>
        <p class="text-gray-700">You'll receive a tracking number via email once your order ships.</p>
      </div>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-4">Still have questions?</h2>
    <p class="text-gray-700 mb-6 text-lg">Our support team is ready to assist you. Don't hesitate to reach out!</p>
    <a href="mailto:support@solemates.ph" class="inline-block px-8 py-3 bg-black text-white font-bold rounded-md hover:bg-gray-800 transition-colors">Send us an Email</a>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php';
