@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Your Properties</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                <th>Property ID</th>
                    <th>Property Name</th>
                    <th>Property Type</th>
                    <th>Property Address</th>
                    <th>Rental Amount (MYR)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($properties as $property)
                    <tr>
                    <td>{{ $property->propertyID }}</td>
                        <td>{{ $property->propertyName }}</td>
                        <td>{{ $property->propertyType }}</td>
                        <td>{{ $property->propertyAddress }}</td>
             
                        <td>{{ number_format($property->rentalAmount, 2) }}</td>
                        <td>
                            <a href="{{ route('properties.show', $property->propertyID) }}" class="btn btn-primary">View As Tenant</a>
                            <a href="{{ route('properties.edit', $property->propertyID) }}" class="btn btn-secondary">Update</a>
                            <form action="{{ route('properties.destroy', $property->propertyID) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this property?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
