<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link
        rel="icon"
        type="image/svg+xml"
        href="/favicon-32x32.png"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>S****Y</title>
</head>
<body>
<div
    id="app"
    class="flex h-full min-h-screen flex-col items-center text-center bg-mainBg text-mainColor"
>
    <header class="bg-mainColor py-5 md:py-3 flex items-start justify-center w-full">
        <h1
            class="animate__animated animate__fadeInDown relative text-accentColor text-[50px] leading-[1.2] md:text-[80px] md:leading-[1] font-black"
        >
            S****Y
            <span
                class="absolute top-[-6px] left-[-54%] md:top-[-3px] md:left-[-60%] text-mainBg text-base md:text-2xl font-light"
            >Hello, this is</span
            >
        </h1>
    </header>
    <div class="text-center max-w-7xl mx-auto md:px-8 md:pt-3">
        <h2 class="animate__animated animate__fadeInDown px-2 text-sm md:text-3xl mb-1 md:mb-3">
            is a personal media buyer's dashboard for convenient and profitable
            traffic uploading.
        </h2>
        <h3 class="animate__animated animate__fadeInDown text-[9px]  md:text-xl uppercase mb-2">
            Custom Android apps, custom push service, comprehensive analytics.
        </h3>
        <div class="flex flex-col md:flex-row max-w-7xl items-center justify-center gap-2 md:gap-[65px]">
            <div class="animate__animated animate__backInLeft w-full pч-2 md:w-1/2 text-center md:text-right">
                <div class="mb-2 md:mb-[100px]">
                    <p class="text-2xl md:text-5xl font-bold md:mb-2">Simplify your life.</p>
                    <p class="text-2xl md:text-5xl font-bold">Just spend.</p>
                </div>
                <p class="text-2xl md:text-5xl font-bold">Easily and profitably.</p>
            </div>
            <div class="w-full md:w-1/2 px-3">
                <h2 class="animate__animated animate__fadeInDown text-base md:text-3xl font-extrabold text-accentColor mb-3 md:mb-6">
                    Leave a request to get access <br />to the pre-release.
                </h2>
                <form
                    autocomplete="off"
                    action="{{ route('appeals.store') }}"
                    method="post"
                    style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;"
                    class="animate__animated animate__backInRight myForm bg-mainColor text-mainBg px-5 py-2 rounded-[25px] "
                >
                    @csrf
                    @method('POST')
                    <div class="mb-3 text-left md:text-xl">
                        <label for="account" class="block mb-2 font-medium text-mainBg"
                        >Your account* (Telegram or WhatsApp)</label
                        >
                        <input
                            type="text"
                            id="account"
                            name="account"
                            required
                            placeholder="Put in your account"
                            class="h-[46px] border placeholder:text-mainColor border-gray-300 text-mainColor shadow p-2 w-full rounded-[17px]"
                        />
                        <x-input-error :messages="$errors->get('account')" class="mt-2" />
                    </div>
                    <div class="mb-3 text-left md:text-xl">
                        <label for="team" class="block mb-2 font-medium text-mainBg"
                        >Your team</label
                        >
                        <input
                            type="text"
                            id="team"
                            name="team"
                            placeholder="Put in your team name"
                            class="h-[46px] border placeholder:text-mainColor border-gray-300 text-mainColor shadow p-2 w-full rounded-[17px]"
                        />
                        <x-input-error :messages="$errors->get('team')" class="mt-2" />
                    </div>
                    <div class="mb-3 text-left md:text-xl">
                        <label for="position" class="block font-medium  mb-2 text-mainBg"
                        >Your team position</label
                        >
                        <input
                            type="text"
                            id="position"
                            name="team_position"
                            placeholder="Put in your position"
                            class="h-[46px] border placeholder:text-mainColor border-gray-300 text-mainColor shadow p-2 w-full rounded-[17px]"
                        />
                        <x-input-error :messages="$errors->get('team_position')" class="mt-2" />
                    </div>

                    <div class="mb-3">
                        <label
                            for="traffic"
                            class="block mb-2 font-medium text-left md:text-xl text-mainBg"
                        >Select a traffic option</label
                        >
                        <select
                            id="traffic"
                            name="traffic_source"
                            class="h-[46px] overflow-hidden bg-gray-50 border border-gray-300 text-mainColor md:text-xl rounded-[17px] focus:ring-blue-500 focus:border-gray-500 block w-full max-w-full p-2"
                        >
                            <option class="w-[100px] text-base md:text-xl text-mainColor" selected>Choose an option</option>
                            <option class="w-[100px] text-base md:text-xl text-mainColor" value="facebook">Facebook</option>
                            <option class="w-[100px] text-base md:text-xl text-mainColor" value="INAPP">InApp</option>
                            <option class="w-[100px] text-base md:text-xl text-mainColor" value="UAC">UAC</option>
                        </select>
                        <x-input-error :messages="$errors->get('traffic_source')" class="mt-2" />
                    </div>

                    <div class="mb-5">
                        <label
                            for="vertical"
                            class="block mb-2 font-medium text-left md:text-xl text-mainBg"
                        >Select a traffic vertical</label
                        >
                        <select
                            id="vertical"
                            name="traffic_vertical"
                            class="h-[46px] overflow-hidden bg-gray-50 border border-gray-300 text-mainColor md:text-xl rounded-[17px] focus:ring-blue-500 focus:border-gray-500 block w-full p-2"
                        >
                            <option class=" text-mainColor" selected>Choose an option</option>
                            <option class=" text-base md:text-xl text-mainColor" value="gamb">Gambling</option>
                            <option class=" text-base md:text-xl text-mainColor" value="INAPP">Dating</option>
                            <option class="text-base md:text-xl text-mainColor" value="UAK">Finance</option>
                        </select>
                        <x-input-error :messages="$errors->get('traffic_vertical')" class="mt-2" />
                    </div>
                    <div>
                        <button type="submit" class="colision">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
