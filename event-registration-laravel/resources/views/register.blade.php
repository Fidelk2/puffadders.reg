@extends('layouts.app')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-3 mb-4 text-sm">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="/register" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-600 mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Jane Wambui"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-600 mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="jane@example.com"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-600 mb-1">M-Pesa Phone Number</label>
            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="0712 345 678"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-600 mb-1">Course / Event</label>
            <select name="course"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                <option value="">Select an event...</option>
                <option value="Web Development Masterclass">Web Development Masterclass</option>
                <option value="Data Science Bootcamp">Data Science Bootcamp</option>
                <option value="UI/UX Design Workshop">UI/UX Design Workshop</option>
            </select>
        </div>

        <div class="bg-gray-50 rounded-lg p-3 mb-6 flex justify-between items-center">
            <span class="text-sm text-gray-500">Registration fee</span>
            <span class="text-xl font-semibold text-green-700">Ksh 100</span>
        </div>

        <button type="submit"
            class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 rounded-lg text-sm transition">
            📱 Pay Ksh 100 via M-Pesa
        </button>
    </form>
</div>
<p class="text-center text-xs text-gray-400 mt-4">🔒 Secured by Safaricom M-Pesa Daraja API</p>
@endsection