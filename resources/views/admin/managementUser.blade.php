@extends('templateAdmin')

@section('content')
<div class="p-6">
    <div class="bg-white rounded-xl shadow p-6">

        <h2 class="text-2xl font-semibold text-gray-800 mb-6">
            Management User
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-3 text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-3 py-3 text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-3 py-3 text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-3 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        @php
                            $statusClass = $user->status === 'Active'
                                ? 'bg-green-200 text-green-800'
                                : 'bg-red-200 text-red-800';
                        @endphp

                        <tr>
                            <td class="px-3 py-3 text-sm">{{ $user->nama }}</td>
                            <td class="px-3 py-3 text-sm">{{ $user->email }}</td>
                            <td class="px-3 py-3 text-sm">{{ $user->role }}</td>

                            <td class="px-3 py-3 text-sm">
                                <form action="{{ route('admin.menegement.userupdateStatus') }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <input type="hidden" name="id_user" value="{{ $user->id }}">

                                    <select name="status"
                                        onchange="this.form.submit()"
                                        class="text-xs font-semibold rounded-full px-3 py-2 cursor-pointer {{ $statusClass }}">
                                        <option value="active" {{ $user->status == 'Active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="non active" {{ $user->status == 'Non Active' ? 'selected' : '' }}>
                                            Non Active
                                        </option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
