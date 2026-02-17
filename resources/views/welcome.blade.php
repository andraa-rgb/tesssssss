<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
        <title>Laravel + Daisy-UI + Vercel</title>

        <!-- Fonts -->

        <!-- Styles -->

    </head>
    <body class="p-4">
        <h1 class="text-3xl font-bold underline text-red-700">
            Hello Laravel
        </h1>

        <div class="mt-10">
            <button class="btn" onclick="hello_modal.showModal()">
                Say Hello daisyui
            </button>

            <dialog id="hello_modal" class="modal">
                <div class="modal-box">
                  <h3 class="font-bold text-lg">Hello from daisy-ui!</h3>
                  <p class="py-4">Press ESC key or click the button below to close</p>
                  <div class="modal-action">
                    <form method="dialog">
                      <!-- if there is a button in form, it will close the modal -->
                      <button class="btn">Close</button>
                    </form>
                  </div>
                </div>
            </dialog>

        </div>
    </body>
</html>
