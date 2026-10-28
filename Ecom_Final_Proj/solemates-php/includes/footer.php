</main>

<footer class="bg-gray-900 text-white pt-12 pb-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      <div>
        <span class="text-2xl font-black tracking-tighter">SOLEMATES</span>
        <p class="mt-4 text-gray-400 text-sm">Your ultimate destination for premium footwear. Walking the path of style since 2024.</p>
      </div>
      <div>
        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-200">Shop</h3>
        <ul class="mt-4 space-y-2">
          <li><a href="<?= BASE_URL ?>/catalog.php?category=Sneakers" class="text-gray-400 hover:text-white text-sm">Sneakers</a></li>
          <li><a href="<?= BASE_URL ?>/catalog.php?category=Running" class="text-gray-400 hover:text-white text-sm">Running</a></li>
          <li><a href="<?= BASE_URL ?>/catalog.php?category=Boots" class="text-gray-400 hover:text-white text-sm">Boots</a></li>
          <li><a href="<?= BASE_URL ?>/catalog.php?category=Casual" class="text-gray-400 hover:text-white text-sm">Casual</a></li>
        </ul>
      </div>
      <div>
        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-200">Support</h3>
        <ul class="mt-4 space-y-2">
          <li><a href="#" class="text-gray-400 hover:text-white text-sm">Order Status</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white text-sm">Shipping & Delivery</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white text-sm">Returns</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white text-sm">Contact Us</a></li>
        </ul>
      </div>
      <div>
        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-200">Stay in the loop</h3>
        <p class="mt-4 text-gray-400 text-sm">Sign up for exclusive offers and new arrivals.</p>
        <form method="post" action="<?= BASE_URL ?>/actions.php" class="mt-4 flex">
          <input type="hidden" name="action" value="subscribe">
          <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
          <input type="email" name="email" placeholder="Enter your email" required
            class="w-full px-3 py-2 text-sm text-black bg-white rounded-l-md focus:outline-none">
          <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-black border border-black rounded-r-md hover:bg-gray-800">Join</button>
        </form>
      </div>
    </div>
    <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center">
      <p class="text-gray-500 text-xs">© 2024 Solemates. All rights reserved.</p>
      <div class="flex space-x-4 mt-4 md:mt-0">
        <div class="w-5 h-5 bg-gray-700 rounded-full"></div>
        <div class="w-5 h-5 bg-gray-700 rounded-full"></div>
        <div class="w-5 h-5 bg-gray-700 rounded-full"></div>
      </div>
    </div>
  </div>
</footer>
</body>
</html>
