<x-app-layout>
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative bg-gray-900 overflow-hidden">
            <div class="absolute inset-0">
                <img class="w-full h-full object-cover opacity-30" src="https://images.unsplash.com/photo-1518384401463-d3876163c195?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="Cosplay Background">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
            </div>
            <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">About ECM Rent Coss</h1>
                <p class="mt-6 text-xl text-gray-300 max-w-3xl">We bring your favorite characters to life. High-quality costumes, hygienic rental service, and a passionate community.</p>
            </div>
        </div>

        <!-- Mission Section -->
        <div class="py-16 bg-gray-50 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Our Story</h2>
                        <p class="mt-4 text-lg text-gray-500">
                            Founded in 2023, ECM Rent Coss started with a simple mission: making high-quality cosplay accessible to everyone. We noticed that buying costumes can be expensive and maintaining them can be a hassle.
                        </p>
                        <p class="mt-4 text-lg text-gray-500">
                            Today, we offer a curated collection of anime, game, and movie costumes. We pride ourselves on the cleanliness of our outfits and the ease of our rental process. Whether for a convention, photoshoot, or party, we have you covered.
                        </p>
                    </div>
                    <div class="mt-8 lg:mt-0 relative">
                        <div class="absolute inset-0 flex items-center justify-center transform -translate-x-4 translate-y-4">
                             <div class="w-full h-full bg-pink-200 rounded-3xl opacity-50"></div>
                        </div>
                        <img class="relative rounded-3xl shadow-xl w-full object-cover" src="https://images.unsplash.com/photo-1578632767115-351597cf2477?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Our Studio">
                    </div>
                </div>
            </div>
        </div>

        <!-- Values Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-base font-semibold text-pink-600 tracking-wide uppercase">Core Values</h2>
                    <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">Why we do it</p>
                </div>
                <div class="mt-12">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="pt-6">
                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <div>
                                        <span class="inline-flex items-center justify-center p-3 bg-pink-500 rounded-md shadow-lg">
                                            <i class="fas fa-heart text-white text-xl"></i>
                                        </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Passion First</h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        We are cosplayers serving cosplayers. We understand the details that matter because we love this culture as much as you do.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <div>
                                        <span class="inline-flex items-center justify-center p-3 bg-pink-500 rounded-md shadow-lg">
                                            <i class="fas fa-sparkles text-white text-xl"></i>
                                        </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Quality & Hygiene</h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        Every costume is professionally cleaned and inspected after every use. You receive it ready to wear and smelling fresh.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6">
                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <div>
                                        <span class="inline-flex items-center justify-center p-3 bg-pink-500 rounded-md shadow-lg">
                                            <i class="fas fa-users text-white text-xl"></i>
                                        </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">Community</h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        We support the local community through events, workshops, and providing a platform for cosplayers to shine.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-pink-600">
            <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">Ready to transform?</span>
                    <span class="block">Explore our catalog today.</span>
                </h2>
                <p class="mt-4 text-lg leading-6 text-pink-100">
                    Find the perfect character for your next event without breaking the bank.
                </p>
                <a href="{{ route('user.catalog.index') }}" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-pink-600 bg-white hover:bg-gray-50 sm:w-auto">
                    Browse Costumes
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
