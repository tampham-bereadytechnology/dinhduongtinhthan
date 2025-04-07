<main class="bg-white dark:bg-gray-800">
    <section class="bg-white dark:bg-gray-800">
        <!-- Header (nếu có) -->
        {{ $header ?? '' }}
        <!-- Container chính với layout 8/4 -->
        <div class="container flex flex-wrap mx-auto mt-5 px-5">
            <!-- Cột 8/12 -->
            <div class="w-full mb-8 pr-0 lg:w-8/12 lg:mb-0 lg:pr-4">
                {{ $slot }} <!-- Nội dung chính (cột 8) được truyền qua slot mặc định -->
            </div>
    
            <!-- Cột 4/12 -->
            <div class="w-full pl-0 rounded-lg lg:pl-4 lg:w-4/12">
                {!! $aside ?? $defaultAside !!} <!-- Nội dung cột 4, mặc định là aside -->
            </div>
        </div>
    </section>
</main>