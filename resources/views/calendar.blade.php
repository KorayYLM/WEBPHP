﻿@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                {{ __('Rental Calendar') }}
            </h2>
            <table id="rental-calendar" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/api/rentals')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#rental-calendar tbody');
                    data.forEach(event => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap">${event.title}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${event.start}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${event.end}</td>
                        `;
                        tbody.appendChild(row);
                    });
                });
        });
    </script>
@endsection
