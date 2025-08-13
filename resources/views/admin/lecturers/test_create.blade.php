<!DOCTYPE html>
<html>
<head>
    <title>Test Lecturer Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Test Lecturer Form</h1>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('admin.lecturers.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="nidn" class="form-label">NIDN *</label>
                <input type="text" class="form-control" id="nidn" name="nidn" value="{{ old('nidn', '9876543210') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="name" class="form-label">Nama *</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', 'Dr. Test Lecturer') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="gender" class="form-label">Gender *</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="">Pilih Gender</option>
                    <option value="male" {{ old('gender', 'male') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', 'test@example.com') }}">
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', '081234567890') }}">
            </div>
            
            <div class="mb-3">
                <label for="faculty_id" class="form-label">Faculty *</label>
                <select class="form-select" id="faculty_id" name="faculty_id" required>
                    <option value="">Pilih Faculty</option>
                    @foreach($faculties as $faculty)
                        <option value="{{ $faculty->id }}" {{ old('faculty_id', $faculties->first()->id) == $faculty->id ? 'selected' : '' }}>
                            {{ $faculty->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label for="position" class="form-label">Position *</label>
                <select class="form-select" id="position" name="position" required>
                    <option value="">Pilih Position</option>
                    @foreach($positions as $position)
                        <option value="{{ $position }}" {{ old('position', 'Lektor') == $position ? 'selected' : '' }}>
                            {{ $position }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Active</label>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit Test</button>
            <a href="{{ route('admin.lecturers.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>
</html>
