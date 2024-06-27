@extends('layouts.header')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Admin | Laundry Management System</title>
</head>
<style>
  body {
    width: 100%;
    height: calc(100%);
  }
  main#main {
    width: 100%;
    height: calc(100%);
    background: white;
  }
  #login-right {
    position: absolute;
    right: 0;
    width: 40%;
    height: calc(100%);
    background: white;
    display: flex;
    align-items: center;
  }
  #login-left {
    position: absolute;
    left: 0;
    width: 60%;
    height: calc(100%);
    background: #59b6ec61;
    display: flex;
    align-items: center;
  }
  #login-right .card {
    margin: auto;
  }
  .logo {
    margin: auto;
    font-size: 8rem;
    background: white;
    padding: .5em 0.7em;
    border-radius: 50% 50%;
    color: #000000b3;
  }
</style>
<body>
  <main id="main" class="bg-dark">
    <div id="login-left">
      <div class="logo">
        <div class="laundry-logo"></div>
      </div>
    </div>
    <div id="login-right">
      <div class="card col-md-8">
        <div class="card-body">
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
              <label for="username" class="control-label">Username</label>
              <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="password" class="control-label">Password</label>
              <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary" type="submit">Login</button></center>
          </form>
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
        </div>
      </div>
    </div>
  </main>
</body>
</html>
