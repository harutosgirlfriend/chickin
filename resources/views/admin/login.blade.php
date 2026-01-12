<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    <link rel="stylesheet" href="../template/assets/css/theme.css" />
    <title>LOGIN</title>
</head>

<body class="DEFAULT_THEME ">

        <div
            class="flex flex-col w-full  overflow-hidden relative min-h-screen radial-gradient items-center justify-center g-0 px-4">

            <div class="justify-center items-center w-full card lg:flex max-w-md ">
                <div class=" w-full card-body">
                    <a href="../" class="py-4 flex justify-center"><img src="{{ asset('images/logo.png') }}"
                            alt="" style="width: 70px" class="" />
                        <span class="font-bold text-lg text-[#e4c6ba] text-center flex items-center"
                            style="color: #b25353">CHICKin</span></a>
                    <p class="mb-4 text-gray-400 text-sm text-center">Masuk ke akunmu</p>
               
                    <form action="{{ route('login') }}">
                
                        <div class="mb-4">
                            <label for="forUsername" class="block text-sm mb-2 text-gray-400">Email</label>
                            <input type="email" id="forUsername"
                                class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 "
                                aria-describedby="hs-input-helper-text" name="email">
                        </div>
          
                        <div class="mb-6">
                            <label for="forPassword" class="block text-sm  mb-2 text-gray-400">Password</label>
                            <input type="password" id="forPassword"
                                class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 "
                                aria-describedby="hs-input-helper-text" name="password">
                        </div>
              
                        <div class="flex justify-between">
                            {{-- <div class="flex"> --}}
                            {{-- <input type="checkbox"
                                    class="shrink-0 mt-0.5 border-gray-200 rounded-[4px] text-blue-600 focus:ring-blue-500 "
                                    id="hs-default-checkbox" checked> --}}
                            {{-- <label for="hs-default-checkbox" class="text-sm text-gray-500 ms-3">Ingat akun</label> --}}
                            {{-- </div> --}}
                            {{-- <a href="../" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Lupa
                                Password ?</a> --}}
                        </div>
                        @if ($errors->any())
                            <div class="text-red-500 text-sm-mt-1 text-center">
                                <ul>
                                    <li>{{ $errors->first() }}</li>
                                </ul>
                            </div>
                        @endif
                
                        <div class="grid my-6">
                            <button class="btn py-[10px] text-base text-white font-medium hover:bg-blue-700"
                                type="submit" style="background-color:#b25353">Masuk</button>
                        </div>

                        <div class="flex justify-center gap-2 items-center">
                            <p class="text-base font-semibold text-gray-400">Pengguna Baru?</p>
                            <a href="{{ route('regis') }}"
                                class="text-sm font-semibold text-blue-600 hover:text-blue-700">Registrasi</a>
                        </div>
                </div>
                </form>
            </div>
        </div>

        </div>
        <!--end of project-->
    </main>



    <script src="../template/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../template/assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="../template/assets/libs/iconify-icon/dist/iconify-icon.min.js"></script>
    <script src="../template/assets/libs/@preline/dropdown/index.js"></script>
    <script src="../template/assets/libs/@preline/overlay/index.js"></script>
    <script src="../template/assets/js/sidebarmenu.js"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="../../assets/libs/preline/dist/preline.js"></script>

</body>

</html>
