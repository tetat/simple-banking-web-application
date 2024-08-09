<!DOCTYPE html>
<html
  class="h-full bg-gray-100"
  lang="en">

  <!-- head section -->
   <?php include(__DIR__ . "/../layouts/head-with-alpine.php") ?>

  <body class="h-full">
    <div class="min-h-full">
      <div class="pb-32 bg-sky-600">

        <!-- Navigation -->
        <?php include(__DIR__ . "/../layouts/admin-navbar.php") ?>

        <header class="py-10">
          <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">
              Add a New Customer
            </h1>
          </div>
        </header>
      </div>

      <main class="-mt-32">
        <div class="px-4 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="bg-white rounded-lg">

            <?php if ($success): ?>
              <p class="text-lg text-green-700 bg-gray-200 p-2 rounded font-bold"><?= $success ?></p>
            <?php endif ?>
            <?php if (isset($errors["auth"])): ?>
              <p class="text-xl text-red-700 bg-gray-200 p-2 rounded font-bold"><?= $errors["auth"] ?></p>
            <?php endif ?>

            <form action="/add/customer" method="POST"
              class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2"
              novalidate>
              <div class="px-4 py-6 sm:p-8">
                <div class="gap-y-8 sm:gap-y-4">
                  <div class="sm:col-span-3">
                    <label
                      for="first-name"
                      class="block text-sm font-medium leading-6 text-gray-900"
                      >Name</label
                    >
                    <div class="mt-2">
                      <input
                        type="text"
                        name="name"
                        id="name"
                        autocomplete="given-name"
                        required
                        class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                    </div>
                    <?php if (isset($errors["name"])): ?>
                        <p class="text-sm text-red-700 font-bold"><?= $errors["name"] ?></p>
                    <?php endif ?>
                  </div>

                  <!-- <div class="sm:col-span-3">
                    <label
                      for="last-name"
                      class="block text-sm font-medium leading-6 text-gray-900"
                      >Last Name</label
                    >
                    <div class="mt-2">
                      <input
                        type="text"
                        name="last-name"
                        id="last-name"
                        autocomplete="family-name"
                        required
                        class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                    </div>
                  </div> -->

                  <div class="sm:col-span-3">
                    <label
                      for="email"
                      class="block text-sm font-medium leading-6 text-gray-900"
                      >Email Address</label
                    >
                    <div class="mt-2">
                      <input
                        type="email"
                        name="email"
                        id="email"
                        autocomplete="email"
                        required
                        class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                    </div>
                    <?php if (isset($errors["email"])): ?>
                      <p class="text-sm text-red-700 font-bold"><?= $errors["email"] ?></p>
                    <?php endif ?>
                  </div>

                  <div class="sm:col-span-3">
                    <label
                      for="password"
                      class="block text-sm font-medium leading-6 text-gray-900"
                      >Password</label
                    >
                    <div class="mt-2">
                      <input
                        type="password"
                        name="password"
                        id="password"
                        autocomplete="password"
                        required
                        class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                    </div>
                    <?php if (isset($errors["password"])): ?>
                        <p class="text-sm text-red-700 font-bold"><?= $errors["password"] ?></p>
                    <?php endif ?>
                  </div>
                  <div class="sm:col-span-3">
                    <label
                      for="password2"
                      class="block text-sm font-medium leading-6 text-gray-900"
                      >Confirm Password</label
                    >
                    <div class="mt-2">
                      <input
                        type="password"
                        name="password2"
                        id="password2"
                        autocomplete="password2"
                        required
                        class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                    </div>
                    <?php if (isset($errors["password2"])): ?>
                        <p class="text-sm text-red-700 font-bold"><?= $errors["password2"] ?></p>
                    <?php endif ?>
                  </div>
                </div>
              </div>
              <div
                class="flex items-center justify-end px-4 py-4 border-t gap-x-6 border-gray-900/10 sm:px-8">
                <!-- <button
                  type="reset"
                  class="text-sm font-semibold leading-6 text-gray-900">
                  Cancel
                </button> -->
                <a type="reset"
                  class="text-sm font-semibold leading-6 text-gray-900"
                  href="<?=previousPage()?>">Cancel</a>
                <button
                  type="submit"
                  class="px-3 py-2 text-sm font-semibold text-white rounded-md shadow-sm bg-sky-600 hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
                  Create Customer
                </button>
              </div>
            </form>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>
