<?php
if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
  $usersFile = '../users/users.json';
  $users = json_decode(file_get_contents($usersFile), true);
  $user = $users[$userId];
}
?>

<header class="relative bg-white z-10">
    <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="./index.php" class="-m-1.5 p-1.5">
                <span class="sr-only">TruthWhisper</span>
                <span class="block font-bold text-lg bg-gradient-to-r from-blue-600 via-green-500 to-indigo-400 inline-block text-transparent bg-clip-text">TruthWhisper</span>
            </a>

            <div class="ms-6 p-1.5">

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="text-sm font-semibold leading-6 text-gray-900 <?php if($page == 'dashboard'){ echo "underline"; } ?> ">Dashboard<span aria-hidden="true"></a>

                <?php endif; ?>

            </div>
        </div>
        
        <div class="flex lg:hidden">
            <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                <span class="sr-only">Open main menu</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">

          <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="./register.php" class="text-sm font-semibold leading-6 text-gray-900">Register<span aria-hidden="true"></a>
            <a href="./login.php" class="ms-5 text-sm font-semibold leading-6 text-gray-900">Log in <span
                aria-hidden="true">&rarr;</span></a>
          <?php else: ?>
            <span class="text-sm font-semibold leading-6 text-gray-900">
                Hello <?= htmlspecialchars($user['name']) ?>!
                <a class="ms-5" href="logout.php">Logout</a>
            </span>
          <?php endif; ?>

        </div>
    </nav>
    <!-- Mobile menu, show/hide based on menu open state. -->
    <div class="lg:hidden" role="dialog" aria-modal="true">
        <!-- Background backdrop, show/hide based on slide-over state. -->
        <div class="fixed inset-0 z-10"></div>
        <div class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
            <div class="flex items-center justify-between">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">TruthWhisper</span>
                    <span class="block font-bold text-xl bg-gradient-to-r from-blue-600 via-green-500 to-indigo-400 inline-block text-transparent bg-clip-text">TruthWhisper</span>

                </a>
                <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Close menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="py-6">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <div>
                            <a href="./register.php" class="text-sm font-semibold leading-6 text-gray-900">Register<span aria-hidden="true"></a>
                        </div>
                        <div>
                            <a href="./login.php" class="ms-5 text-sm font-semibold leading-6 text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
                        </div>
                    <?php else: ?>
                        <div>
                            <div>
                                <span class="text-sm font-semibold leading-6 text-gray-900">
                                    Hello <?= htmlspecialchars($user['name']) ?>!
                                </span>
                            </div>
                            <div>
                                <a href="dashboard.php" class="text-sm font-semibold leading-6 text-gray-900">
                                    Dashboard<span aria-hidden="true">
                                </a>
                            </div>
                            <div>
                                <span class="text-sm font-semibold leading-6 text-gray-900">
                                    <a class="" href="logout.php">Logout</a>
                                </span>
                            </div>

                        </div>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>