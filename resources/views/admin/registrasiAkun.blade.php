@extends('templateAdmin')



@section('content')

    <div class="col-span-1 xl:col-span-1 md:col-span-6">
        <div class="card">
            <div class="flex justify-between card-header !pb-0 !border-b-0">
                <h5>Data Akun Admin</h5>
                <button class="px-4 py-2 border bg-purple-300 hover:text-white transition">Tambah</button>
            </div>
            <div class="card-body table">

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border border-gray-300">
                                    Song
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Artist
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Year
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">The Sliding Mr. Bones (Next Stop, Pottersville)</td>
                                <td class="px-6 py-4 whitespace-nowrap">Malcolm Lockyer</td>
                                <td class="px-6 py-4 whitespace-nowrap">1961</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">Witchy Woman</td>
                                <td class="px-6 py-4 whitespace-nowrap">The Eagles</td>
                                <td class="px-6 py-4 whitespace-nowrap">1972</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">Shining Star</td>
                                <td class="px-6 py-4 whitespace-nowrap">Earth, Wind, and Fire</td>
                                <td class="px-6 py-4 whitespace-nowrap">1975</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>


@endsection
