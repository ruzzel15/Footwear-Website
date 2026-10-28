<?php
$page_title = 'Sign In – Solemates';
require_once __DIR__ . '/includes/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full space-y-8">
    <div class="text-center">
      <svg class="mx-auto h-12 w-12 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
      </svg>
      <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Sign in to your account</h2>
      <p class="mt-2 text-sm text-gray-600">
        Or <a href="<?= BASE_URL ?>/register.php" class="font-medium text-black hover:underline">create a new account</a>
      </p>
    </div>

    <form method="post" action="<?= BASE_URL ?>/actions.php" class="mt-8 space-y-6">
      <input type="hidden" name="action" value="login">
      <div class="rounded-md shadow-sm -space-y-px">
        <div>
          <label for="email" class="sr-only">Email address</label>
          <input id="email" name="email" type="email" autocomplete="email" required
            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-black focus:border-black sm:text-sm"
            placeholder="Email address">
        </div>
        <div>
          <label for="password" class="sr-only">Password</label>
          <input id="password" name="password" type="password" autocomplete="current-password" required
            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-black focus:border-black sm:text-sm"
            placeholder="Password">
        </div>
      </div>

      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
          <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
        </div>
        <a href="#" class="text-sm font-medium text-black hover:underline">Forgot your password?</a>
      </div>

      <div>
        <button type="submit"
          class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
          Sign in
        </button>
        <p class="text-xs text-center mt-2 text-gray-500">Hint: Use 'admin' in email to access Admin Dashboard.</p>
      </div>
    </form>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
