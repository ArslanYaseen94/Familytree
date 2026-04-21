@extends('layouts.user.app')
@section('content')
    <div class="main-content right-chat-active">
        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left pe-0">
                <div class="container">
                    <div class="card-header bg-primary text-white rounded-4">
                        <h4 class="mb-0 p-4">Create New Entry</h4>
                    </div>
                    <div class="card shadow rounded-4 mt-3">
                        <div class="card-body mt-3">
                            <form action="" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Enter full name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter email"
                                            required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" name="phone" class="form-control"
                                            placeholder="Enter phone number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" name="dob" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select name="gender" class="form-select" required>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea name="address" class="form-control" rows="2" placeholder="Enter address"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Role</label>
                                        <select name="gender" class="form-select" required>

                                            <option value="male">Parents</option>
                                            <option value="female">Spouse</option>
                                            <option value="other">Children</option>
                                            <option value="other">Siblings</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Place of Birth</label>
                                        <input name="address" class="form-control" rows="2"
                                            placeholder="Enter Place of Birth" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                   <div class="col-md-6">
                                        <label for="address" class="form-label">Home Town</label>
                                        <input name="address" class="form-control" rows="2"
                                            placeholder="Enter Home Town" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">School</label>
                                        <input name="address" class="form-control" rows="2"
                                            placeholder="Enter School" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                   <div class="col-md-6">
                                        <label for="address" class="form-label">Background</label>
                                        <input name="address" class="form-control" rows="2"
                                            placeholder="Enter your background" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Social Media</label>
                                        <input name="address" class="form-control" rows="2"
                                            placeholder="Enter Social Media" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                   <div class="col-md-6">
                                        <label for="address" class="form-label">Business Info</label>
                                        <input name="address" class="form-control" rows="2"
                                            placeholder="Enter your Business Info" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Profession</label>
                                        <input name="address" class="form-control" rows="2"
                                            placeholder="Enter your Profession" />
                                    </div>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="deceased" value="1"
                                        id="deceased">
                                    <label class="form-check-label" for="deceased">
                                        Deceased
                                    </label>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-success px-4">Submit</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary px-4">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
