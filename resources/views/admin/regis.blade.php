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
    <!-- Core Css -->
    <link rel="stylesheet" href="../template/assets/css/theme.css" />
    <title>CHICKin</title>
</head>

<body class="DEFAULT_THEME bg-white">
    <main>

        <div
            class="flex flex-col w-full  overflow-hidden relative min-h-screen radial-gradient items-center justify-center g-0 px-4">

            <div class="justify-center items-center w-full card lg:flex max-w-md ">
                <div class=" w-full card-body">
                 <a href="../" class="py-4 flex justify-center"><img src="{{ asset('images/logo.png') }}"
                            alt="" style="width: 70px" class="" />
                        <span class="font-bold text-lg text-[#e4c6ba] text-center flex items-center"
                            style="color: #b25353">CHICKin</span></a>
                    <p class="mb-4 text-gray-400 text-sm text-center">CHICKin</p>
         
                    <form action="{{ route('regis.save') }}">
       
                     
                            <div class="mb-4">
                                <label for="forName" class="block text-sm  mb-2 text-gray-400">Nama</label>
                                <input type="text" id="forName"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 "
                                    aria-describedby="hs-input-helper-text" name="nama" value="{{ old('nama') }}">
                                    @error('nama')
                                    <p class="text-red-500 text-sm-mt-1">{{ $message }}</p>
                                    @enderror
                            </div>
                        <div class="mb-4">
                            <label for="forEmail" class="block text-sm  mb-2 text-gray-400">Email</label>
                            <input type="email" id="forEmail"
                                class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 "
                                aria-describedby="hs-input-helper-text" name="email" value="{{ old('email') }}">
                                  @error('email')
                                    <p class="text-red-500 text-sm-mt-1">{{ $message }}</p>
                                    @enderror
                        </div>

                        <div class="mb-4">
                            <label for="forEmail" class="block text-sm  mb-2 text-gray-400">Nomor Hp</label>
                            <input type="text" id="forEmail"
                                class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 "
                                aria-describedby="hs-input-helper-text" name="no_hp" value="{{ old('no_hp') }}">
                                  @error('no_hp')
                                    <p class="text-red-500 text-sm-mt-1">{{ $message }}</p>
                                    @enderror
                        </div>

                        <div class="mb-4">
                            <label for="forPassword" class="block text-sm  mb-2 text-gray-400">Password</label>
                            <input type="password" id="forPassword"
                                class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 "
                                aria-describedby="hs-input-helper-text" name="password" value="{{ old('password') }}">
                                  @error('password')
                                    <p class="text-red-500 text-sm-mt-1">{{ $message }}</p>
                                    @enderror
                        </div>
         
                        <div class="mb-4">
                            <label for="forPassword" class="block text-sm  mb-2 text-gray-400">Confirm Password</label>
                            <input type="password" id="forPassword"
                                class="py-3 px-4 block w-full border-gray-200 rounded-sm text-sm focus:border-blue-600 focus:ring-0 "
                                aria-describedby="hs-input-helper-text" name="password_confirmation">
                        </div>

                        <div class="grid my-6">
                            <button type="submit"
                                class="btn py-[10px] text-base text-white font-medium bg-[#b25353]" style="background-color: #b25353">registrasi</button>
                        </div>

                        <div class="flex justify-center gap-2 items-center">
                            <p class="text-base font-semibold text-gray-400">Sudah Punya Akun?</p>
                            <a href="{{ route('login.view') }}"
                                class="text-sm font-semibold text-blue-600 hover:text-blue-700">Login</a>
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
