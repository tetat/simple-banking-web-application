<!DOCTYPE html>
<html
  class="h-full bg-white"
  lang="en">
  
  <!-- head section -->
  <?php include("layouts/head.php") ?>

  <body class="h-full bg-slate-100">
    <div class="flex flex-col justify-center min-h-full py-12 sm:px-6 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2
          class="mt-6 text-2xl font-bold leading-9 tracking-tight text-center text-gray-900">
          Create A New Account
        </h2>
      </div>

      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
        <div class="px-6 py-12 bg-white shadow sm:rounded-lg sm:px-12">

        <?php if (isset($errors["auth"])): ?>
            <p class="text-xl text-red-700 bg-gray-200 p-2 rounded font-bold"><?= $errors["auth"] ?></p>
        <?php endif ?>

          <form
            class="space-y-2"
            action="/register/store"
            method="POST" novalidate>
            <div>
              <label
                for="name"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Name</label
              >
              <div class="mt-2">
                <input
                  id="name"
                  name="name"
                  type="text"
                  value="<?= old('name') ?>"
                  required
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 p-2" />
              </div>
              <?php if (isset($errors["name"])): ?>
                  <p class="text-sm text-red-700 font-bold"><?= $errors["name"] ?></p>
              <?php endif ?>
            </div>

            <div class="mt-0">
              <label
                for="email"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Email address</label
              >
              <div class="mt-2">
                <input
                  id="email"
                  name="email"
                  type="email"
                  autocomplete="email"
                  value="<?= old('email') ?>"
                  required
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 p-2" />
              </div>
              <?php if (isset($errors["email"])): ?>
                  <p class="text-sm text-red-700 font-bold"><?= $errors["email"] ?></p>
              <?php endif ?>
            </div>

            <div class="mt-0">
              <label
                for="password"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Password</label
              >
              <div class="mt-2">
                <input
                  id="password"
                  name="password"
                  type="password"
                  autocomplete="current-password"
                  required
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 p-2" />
              </div>
              <?php if (isset($errors["password"])): ?>
                  <p class="text-sm text-red-700 font-bold"><?= $errors["password"] ?></p>
              <?php endif ?>
            </div>

            <div class="mt-0">
              <label
                for="password2"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Confirm Password</label
              >
              <div class="mt-2">
                <input
                  id="password2"
                  name="password2"
                  type="password"
                  autocomplete="password2"
                  required
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 p-2" />
              </div>
              <?php if (isset($errors["password2"])): ?>
                  <p class="text-sm text-red-700 font-bold"><?= $errors["password2"] ?></p>
              <?php endif ?>
            </div>


            <div>
              <button
                type="submit"
                class="flex w-full justify-center rounded-md bg-emerald-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                Register
              </button>
            </div>
          </form>
        </div>

        <p class="mt-10 text-sm text-center text-gray-500">
          Already a customer?
          <a
            href="/login/create"
            class="font-semibold leading-6 text-emerald-600 hover:text-emerald-500"
            >Sign-in</a
          >
        </p>
      </div>
    </div>
  </body>
</html>
