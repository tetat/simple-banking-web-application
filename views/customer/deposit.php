<!DOCTYPE html>
<html
  class="h-full bg-gray-100"
  lang="en">

  <!-- head section -->
  <?php include(__DIR__ . "/../layouts/head-with-alpine.php") ?>

  <body class="h-full">
    <div class="min-h-full">
      <div class="bg-emerald-600 pb-32">
        
        <!-- Navigation -->
        <?php include(__DIR__ . "/../layouts/customer-navbar.php") ?>

        <header class="py-10">
          <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">
              Deposit Balance
            </h1>
          </div>
        </header>
      </div>

      <main class="-mt-32">
        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
          <div class="bg-white rounded-lg p-2">

            <?php foreach($errors as $key => $value): ?>
              <p class="text-sm text-red-700 p-2 rounded font-bold"><?= $value ?></p>
            <?php endforeach ?>

            <?php if ($success) {
              include(__DIR__ . '/../alerts/success-alert.php');
            } ?>

            <!-- Current Balance Stat -->
            <dl
              class="mx-auto grid grid-cols-1 gap-px sm:grid-cols-2 lg:grid-cols-4">
              <div
                class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-4 py-10 sm:px-6 xl:px-8">
                <dt class="text-sm font-medium leading-6 text-gray-500">
                  Current Balance
                </dt>
                <dd
                  class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
                  $<?= number_format($balance, 2, '.', ',') ?>
                </dd>
              </div>
            </dl>

            <hr />
            <!-- Deposit Form -->
            <div class="sm:rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-semibold leading-6 text-gray-800">
                  Deposit Money To Your Account
                </h3>
                <div class="mt-4 text-sm text-gray-500">
                  <form
                    action="/customer/deposit"
                    method="POST"
                    novalidate>
                    <!-- Input Field -->
                    <div class="relative mt-2 rounded-md">
                      <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-0">
                        <span class="text-gray-400 sm:text-4xl">$</span>
                      </div>
                      <input
                        type="number"
                        name="amount"
                        id="amount"
                        value="<?= old('amount') ?>"
                        class="block w-full ring-0 outline-none text-xl pl-4 py-2 sm:pl-8 text-gray-800 border-b border-b-emerald-500 placeholder:text-gray-400 sm:text-4xl"
                        placeholder="1.00"
                        min="1"
                        required />
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-5">
                      <button
                        type="submit"
                        class="w-full px-6 py-3.5 text-base font-medium text-white bg-emerald-600 hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-emerald-300 rounded-lg sm:text-xl text-center">
                        Proceed
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>
