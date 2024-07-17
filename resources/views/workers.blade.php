@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    Cотрудники
                </h1>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="row">
                <form class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                          <h5 class="card-title"><i class="fa fa-filter" aria-hidden="true"></i> Фильтр</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <button type="button" class="btn btn-default float-right" id="daterange-btn">
                                        <i class="far fa-calendar-alt"></i> Выберите дату или период
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </div>
                                <div id="reportrange"><span></span></div>
                            </div>
                            <div class="form-group">
                                <label><i class="fa fa-users" aria-hidden="true"></i> Сотрудники:</label>
                                <select class="select2" multiple="multiple" data-placeholder="Выберите сотрудника" style="width: 100%;">
                                    <option>Сотрудник 1</option>
                                    <option>Сотрудник 2</option>
                                    <option>Сотрудник 3</option>
                                    <option>Сотрудник 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Применить</button>
                            </div>
                        </div>
                      </div>
                </form>
                <div class="col-md-8">

                    <div class="row">
                        <div class="col-12 py-3">
                            <h4>Если выбран день:</h4>
                        </div>
                        <div class="col-lg-6">
                            <form class="card bg-white d-flex flex-fill">
                                <div class="card-body pt-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-muted pb-1">
                                                Digital Strategist
                                            </div>
                                            <h2 class="lead"><b>Nicole Pearson</b></h2>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:+80012122352">+(800) 121-223-22</a></li>
                                                <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:user.email@email.com">user.email@email.com</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center"><img alt="user-avatar" class="user-avatar img-circle img-fluid" src="{{ asset('vendor/adminlte/dist/img/user1-128x128.jpg') }}"></div>
                                    </div>
                                </div><div class="card-body p-0">
                                    <table class="table table-sm client-table">
                                      <tbody>
                                        <tr>
                                          <td style="width: 10px">1.</td>
                                          <td>Клиент 2</td>
                                          <td style="width: 82px; text-align: right;">
                                              <select class="form-control-off" name="work_hours_of_day">
                                                  <option value="0">0</option>
                                                  <option value="0.5">0.5</option>
                                                  <option value="1">1</option>
                                                  <option value="1.5">1.5</option>
                                                  <option value="2">2</option>
                                                  <option value="2.5">2.5</option>
                                                  <option value="3">3</option>
                                                  <option value="3.5" selected>3.5</option>
                                                  <option value="4">4</option>
                                                  <option value="4.5">4.5</option>
                                                  <option value="5">5</option>
                                                  <option value="5.5">5.5</option>
                                                  <option value="6">6</option>
                                                  <option value="6.5">6.5</option>
                                                  <option value="7">7</option>
                                                  <option value="7.5">7.5</option>
                                                  <option value="8">8</option>
                                                  <option value="8.5">8.5</option>
                                                  <option value="9">9</option>
                                                  <option value="9.5">9.5</option>
                                                  <option value="10">10</option>
                                                  <option value="10.5">10.5</option>
                                                  <option value="11">11</option>
                                                  <option value="11.5">11.5</option>
                                                  <option value="12">12</option>
                                                  <option value="12.5">12.5</option>
                                                  <option value="13">13</option>
                                                  <option value="13.5">13.5</option>
                                                  <option value="14">14</option>
                                                  <option value="14.5">14.5</option>
                                                  <option value="15">15</option>
                                                  <option value="15.5">15.5</option>
                                                  <option value="16">16</option>
                                              </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>2.</td>
                                          <td>Клиент 3</td>
                                          <td style="width: 82px; text-align: right;">
                                              <select class="form-control-off" name="work_hours_of_day">
                                                  <option value="0">0</option>
                                                  <option value="0.5">0.5</option>
                                                  <option value="1">1</option>
                                                  <option value="1.5">1.5</option>
                                                  <option value="2" selected>2</option>
                                                  <option value="2.5">2.5</option>
                                                  <option value="3">3</option>
                                                  <option value="3.5">3.5</option>
                                                  <option value="4">4</option>
                                                  <option value="4.5">4.5</option>
                                                  <option value="5">5</option>
                                                  <option value="5.5">5.5</option>
                                                  <option value="6">6</option>
                                                  <option value="6.5">6.5</option>
                                                  <option value="7">7</option>
                                                  <option value="7.5">7.5</option>
                                                  <option value="8">8</option>
                                                  <option value="8.5">8.5</option>
                                                  <option value="9">9</option>
                                                  <option value="9.5">9.5</option>
                                                  <option value="10">10</option>
                                                  <option value="10.5">10.5</option>
                                                  <option value="11">11</option>
                                                  <option value="11.5">11.5</option>
                                                  <option value="12">12</option>
                                                  <option value="12.5">12.5</option>
                                                  <option value="13">13</option>
                                                  <option value="13.5">13.5</option>
                                                  <option value="14">14</option>
                                                  <option value="14.5">14.5</option>
                                                  <option value="15">15</option>
                                                  <option value="15.5">15.5</option>
                                                  <option value="16">16</option>
                                              </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>3.</td>
                                          <td>Клиент 4</td>
                                          <td style="width: 82px; text-align: right;">
                                              <select class="form-control-off" name="work_hours_of_day">
                                                  <option value="0">0</option>
                                                  <option value="0.5">0.5</option>
                                                  <option value="1">1</option>
                                                  <option value="1.5">1.5</option>
                                                  <option value="2">2</option>
                                                  <option value="2.5" selected>2.5</option>
                                                  <option value="3">3</option>
                                                  <option value="3.5">3.5</option>
                                                  <option value="4">4</option>
                                                  <option value="4.5">4.5</option>
                                                  <option value="5">5</option>
                                                  <option value="5.5">5.5</option>
                                                  <option value="6">6</option>
                                                  <option value="6.5">6.5</option>
                                                  <option value="7">7</option>
                                                  <option value="7.5">7.5</option>
                                                  <option value="8">8</option>
                                                  <option value="8.5">8.5</option>
                                                  <option value="9">9</option>
                                                  <option value="9.5">9.5</option>
                                                  <option value="10">10</option>
                                                  <option value="10.5">10.5</option>
                                                  <option value="11">11</option>
                                                  <option value="11.5">11.5</option>
                                                  <option value="12">12</option>
                                                  <option value="12.5">12.5</option>
                                                  <option value="13">13</option>
                                                  <option value="13.5">13.5</option>
                                                  <option value="14">14</option>
                                                  <option value="14.5">14.5</option>
                                                  <option value="15">15</option>
                                                  <option value="15.5">15.5</option>
                                                  <option value="16">16</option>
                                              </select>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <span class="data-total"><i class="far fa-clock"></i> 8</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <form class="card bg-white d-flex flex-fill">
                                <div class="card-body pt-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-muted pb-1">
                                                Digital Strategist
                                            </div>
                                            <h2 class="lead"><b>Nicole Pearson</b></h2>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:+80012122352">+(800) 121-223-22</a></li>
                                                <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:user.email@email.com">user.email@email.com</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center"><img alt="user-avatar" class="user-avatar img-circle img-fluid" src="{{ asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}"></div>
                                    </div>
                                </div><div class="card-body p-0">
                                    <table class="table table-sm client-table">
                                      <tbody>
                                        <tr>
                                          <td style="width: 10px">1.</td>
                                          <td>Клиент 2</td>
                                          <td style="width: 82px; text-align: right;">
                                              <select class="form-control-off" name="work_hours_of_day">
                                                  <option value="0">0</option>
                                                  <option value="0.5">0.5</option>
                                                  <option value="1">1</option>
                                                  <option value="1.5">1.5</option>
                                                  <option value="2">2</option>
                                                  <option value="2.5">2.5</option>
                                                  <option value="3">3</option>
                                                  <option value="3.5" selected>3.5</option>
                                                  <option value="4">4</option>
                                                  <option value="4.5">4.5</option>
                                                  <option value="5">5</option>
                                                  <option value="5.5">5.5</option>
                                                  <option value="6">6</option>
                                                  <option value="6.5">6.5</option>
                                                  <option value="7">7</option>
                                                  <option value="7.5">7.5</option>
                                                  <option value="8">8</option>
                                                  <option value="8.5">8.5</option>
                                                  <option value="9">9</option>
                                                  <option value="9.5">9.5</option>
                                                  <option value="10">10</option>
                                                  <option value="10.5">10.5</option>
                                                  <option value="11">11</option>
                                                  <option value="11.5">11.5</option>
                                                  <option value="12">12</option>
                                                  <option value="12.5">12.5</option>
                                                  <option value="13">13</option>
                                                  <option value="13.5">13.5</option>
                                                  <option value="14">14</option>
                                                  <option value="14.5">14.5</option>
                                                  <option value="15">15</option>
                                                  <option value="15.5">15.5</option>
                                                  <option value="16">16</option>
                                              </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>2.</td>
                                          <td>Клиент 3</td>
                                          <td style="width: 82px; text-align: right;">
                                              <select class="form-control-off" name="work_hours_of_day">
                                                  <option value="0">0</option>
                                                  <option value="0.5">0.5</option>
                                                  <option value="1">1</option>
                                                  <option value="1.5">1.5</option>
                                                  <option value="2" selected>2</option>
                                                  <option value="2.5">2.5</option>
                                                  <option value="3">3</option>
                                                  <option value="3.5">3.5</option>
                                                  <option value="4">4</option>
                                                  <option value="4.5">4.5</option>
                                                  <option value="5">5</option>
                                                  <option value="5.5">5.5</option>
                                                  <option value="6">6</option>
                                                  <option value="6.5">6.5</option>
                                                  <option value="7">7</option>
                                                  <option value="7.5">7.5</option>
                                                  <option value="8">8</option>
                                                  <option value="8.5">8.5</option>
                                                  <option value="9">9</option>
                                                  <option value="9.5">9.5</option>
                                                  <option value="10">10</option>
                                                  <option value="10.5">10.5</option>
                                                  <option value="11">11</option>
                                                  <option value="11.5">11.5</option>
                                                  <option value="12">12</option>
                                                  <option value="12.5">12.5</option>
                                                  <option value="13">13</option>
                                                  <option value="13.5">13.5</option>
                                                  <option value="14">14</option>
                                                  <option value="14.5">14.5</option>
                                                  <option value="15">15</option>
                                                  <option value="15.5">15.5</option>
                                                  <option value="16">16</option>
                                              </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>3.</td>
                                          <td>Клиент 4</td>
                                          <td style="width: 82px; text-align: right;">
                                              <select class="form-control-off" name="work_hours_of_day">
                                                  <option value="0">0</option>
                                                  <option value="0.5">0.5</option>
                                                  <option value="1">1</option>
                                                  <option value="1.5">1.5</option>
                                                  <option value="2">2</option>
                                                  <option value="2.5" selected>2.5</option>
                                                  <option value="3">3</option>
                                                  <option value="3.5">3.5</option>
                                                  <option value="4">4</option>
                                                  <option value="4.5">4.5</option>
                                                  <option value="5">5</option>
                                                  <option value="5.5">5.5</option>
                                                  <option value="6">6</option>
                                                  <option value="6.5">6.5</option>
                                                  <option value="7">7</option>
                                                  <option value="7.5">7.5</option>
                                                  <option value="8">8</option>
                                                  <option value="8.5">8.5</option>
                                                  <option value="9">9</option>
                                                  <option value="9.5">9.5</option>
                                                  <option value="10">10</option>
                                                  <option value="10.5">10.5</option>
                                                  <option value="11">11</option>
                                                  <option value="11.5">11.5</option>
                                                  <option value="12">12</option>
                                                  <option value="12.5">12.5</option>
                                                  <option value="13">13</option>
                                                  <option value="13.5">13.5</option>
                                                  <option value="14">14</option>
                                                  <option value="14.5">14.5</option>
                                                  <option value="15">15</option>
                                                  <option value="15.5">15.5</option>
                                                  <option value="16">16</option>
                                              </select>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <span class="data-total"><i class="far fa-clock"></i> 8</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <form class="card bg-white d-flex flex-fill">
                                <div class="card-body pt-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-muted pb-1">
                                                Digital Strategist
                                            </div>
                                            <h2 class="lead"><b>Nicole Pearson</b></h2>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:+80012122352">+(800) 121-223-22</a></li>
                                                <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:user.email@email.com">user.email@email.com</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center"><img alt="user-avatar" class="user-avatar img-circle img-fluid" src="{{ asset('vendor/adminlte/dist/img/user-woman.jpg') }}"></div>
                                    </div>
                                </div><div class="card-body p-0">
                                    <table class="table table-sm client-table">
                                      <tbody>
                                        <tr>
                                          <td style="width: 10px">1.</td>
                                          <td>Клиент 2</td>
                                          <td style="width: 82px; text-align: right;">
                                              <select class="form-control-off" name="work_hours_of_day">
                                                  <option value="0">0</option>
                                                  <option value="0.5">0.5</option>
                                                  <option value="1">1</option>
                                                  <option value="1.5">1.5</option>
                                                  <option value="2">2</option>
                                                  <option value="2.5">2.5</option>
                                                  <option value="3">3</option>
                                                  <option value="3.5" selected>3.5</option>
                                                  <option value="4">4</option>
                                                  <option value="4.5">4.5</option>
                                                  <option value="5">5</option>
                                                  <option value="5.5">5.5</option>
                                                  <option value="6">6</option>
                                                  <option value="6.5">6.5</option>
                                                  <option value="7">7</option>
                                                  <option value="7.5">7.5</option>
                                                  <option value="8">8</option>
                                                  <option value="8.5">8.5</option>
                                                  <option value="9">9</option>
                                                  <option value="9.5">9.5</option>
                                                  <option value="10">10</option>
                                                  <option value="10.5">10.5</option>
                                                  <option value="11">11</option>
                                                  <option value="11.5">11.5</option>
                                                  <option value="12">12</option>
                                                  <option value="12.5">12.5</option>
                                                  <option value="13">13</option>
                                                  <option value="13.5">13.5</option>
                                                  <option value="14">14</option>
                                                  <option value="14.5">14.5</option>
                                                  <option value="15">15</option>
                                                  <option value="15.5">15.5</option>
                                                  <option value="16">16</option>
                                              </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>2.</td>
                                          <td>Клиент 3</td>
                                          <td style="width: 82px; text-align: right;">
                                              <select class="form-control-off" name="work_hours_of_day">
                                                  <option value="0">0</option>
                                                  <option value="0.5">0.5</option>
                                                  <option value="1">1</option>
                                                  <option value="1.5">1.5</option>
                                                  <option value="2" selected>2</option>
                                                  <option value="2.5">2.5</option>
                                                  <option value="3">3</option>
                                                  <option value="3.5">3.5</option>
                                                  <option value="4">4</option>
                                                  <option value="4.5">4.5</option>
                                                  <option value="5">5</option>
                                                  <option value="5.5">5.5</option>
                                                  <option value="6">6</option>
                                                  <option value="6.5">6.5</option>
                                                  <option value="7">7</option>
                                                  <option value="7.5">7.5</option>
                                                  <option value="8">8</option>
                                                  <option value="8.5">8.5</option>
                                                  <option value="9">9</option>
                                                  <option value="9.5">9.5</option>
                                                  <option value="10">10</option>
                                                  <option value="10.5">10.5</option>
                                                  <option value="11">11</option>
                                                  <option value="11.5">11.5</option>
                                                  <option value="12">12</option>
                                                  <option value="12.5">12.5</option>
                                                  <option value="13">13</option>
                                                  <option value="13.5">13.5</option>
                                                  <option value="14">14</option>
                                                  <option value="14.5">14.5</option>
                                                  <option value="15">15</option>
                                                  <option value="15.5">15.5</option>
                                                  <option value="16">16</option>
                                              </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>3.</td>
                                          <td>Клиент 4</td>
                                          <td style="width: 82px; text-align: right;">
                                              <select class="form-control-off" name="work_hours_of_day">
                                                  <option value="0">0</option>
                                                  <option value="0.5">0.5</option>
                                                  <option value="1">1</option>
                                                  <option value="1.5">1.5</option>
                                                  <option value="2">2</option>
                                                  <option value="2.5" selected>2.5</option>
                                                  <option value="3">3</option>
                                                  <option value="3.5">3.5</option>
                                                  <option value="4">4</option>
                                                  <option value="4.5">4.5</option>
                                                  <option value="5">5</option>
                                                  <option value="5.5">5.5</option>
                                                  <option value="6">6</option>
                                                  <option value="6.5">6.5</option>
                                                  <option value="7">7</option>
                                                  <option value="7.5">7.5</option>
                                                  <option value="8">8</option>
                                                  <option value="8.5">8.5</option>
                                                  <option value="9">9</option>
                                                  <option value="9.5">9.5</option>
                                                  <option value="10">10</option>
                                                  <option value="10.5">10.5</option>
                                                  <option value="11">11</option>
                                                  <option value="11.5">11.5</option>
                                                  <option value="12">12</option>
                                                  <option value="12.5">12.5</option>
                                                  <option value="13">13</option>
                                                  <option value="13.5">13.5</option>
                                                  <option value="14">14</option>
                                                  <option value="14.5">14.5</option>
                                                  <option value="15">15</option>
                                                  <option value="15.5">15.5</option>
                                                  <option value="16">16</option>
                                              </select>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <span class="data-total"><i class="far fa-clock"></i> 8</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <form class="card bg-white d-flex flex-fill">
                                <div class="card-body pt-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-muted pb-1">
                                                Digital Strategist
                                            </div>
                                            <h2 class="lead"><b>Nicole Pearson</b></h2>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:+80012122352">+(800) 121-223-22</a></li>
                                                <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:user.email@email.com">user.email@email.com</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center"><img alt="user-avatar" class="user-avatar img-circle img-fluid" src="{{ asset('vendor/adminlte/dist/img/no-usericon.svg') }}"></div>
                                    </div>
                                </div><div class="card-body p-0">
                                    <table class="table table-sm client-table">
                                      <tbody>
                                        <tr>
                                          <td style="width: 10px">1.</td>
                                          <td>Клиент 2</td>
                                          <td style="width: 82px; text-align: right;">
                                              <select class="form-control-off" name="work_hours_of_day">
                                                  <option value="0">0</option>
                                                  <option value="0.5">0.5</option>
                                                  <option value="1">1</option>
                                                  <option value="1.5">1.5</option>
                                                  <option value="2">2</option>
                                                  <option value="2.5">2.5</option>
                                                  <option value="3">3</option>
                                                  <option value="3.5" selected>3.5</option>
                                                  <option value="4">4</option>
                                                  <option value="4.5">4.5</option>
                                                  <option value="5">5</option>
                                                  <option value="5.5">5.5</option>
                                                  <option value="6">6</option>
                                                  <option value="6.5">6.5</option>
                                                  <option value="7">7</option>
                                                  <option value="7.5">7.5</option>
                                                  <option value="8">8</option>
                                                  <option value="8.5">8.5</option>
                                                  <option value="9">9</option>
                                                  <option value="9.5">9.5</option>
                                                  <option value="10">10</option>
                                                  <option value="10.5">10.5</option>
                                                  <option value="11">11</option>
                                                  <option value="11.5">11.5</option>
                                                  <option value="12">12</option>
                                                  <option value="12.5">12.5</option>
                                                  <option value="13">13</option>
                                                  <option value="13.5">13.5</option>
                                                  <option value="14">14</option>
                                                  <option value="14.5">14.5</option>
                                                  <option value="15">15</option>
                                                  <option value="15.5">15.5</option>
                                                  <option value="16">16</option>
                                              </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>2.</td>
                                          <td>Клиент 3</td>
                                          <td style="width: 82px; text-align: right;">
                                              <select class="form-control-off" name="work_hours_of_day">
                                                  <option value="0">0</option>
                                                  <option value="0.5">0.5</option>
                                                  <option value="1">1</option>
                                                  <option value="1.5">1.5</option>
                                                  <option value="2" selected>2</option>
                                                  <option value="2.5">2.5</option>
                                                  <option value="3">3</option>
                                                  <option value="3.5">3.5</option>
                                                  <option value="4">4</option>
                                                  <option value="4.5">4.5</option>
                                                  <option value="5">5</option>
                                                  <option value="5.5">5.5</option>
                                                  <option value="6">6</option>
                                                  <option value="6.5">6.5</option>
                                                  <option value="7">7</option>
                                                  <option value="7.5">7.5</option>
                                                  <option value="8">8</option>
                                                  <option value="8.5">8.5</option>
                                                  <option value="9">9</option>
                                                  <option value="9.5">9.5</option>
                                                  <option value="10">10</option>
                                                  <option value="10.5">10.5</option>
                                                  <option value="11">11</option>
                                                  <option value="11.5">11.5</option>
                                                  <option value="12">12</option>
                                                  <option value="12.5">12.5</option>
                                                  <option value="13">13</option>
                                                  <option value="13.5">13.5</option>
                                                  <option value="14">14</option>
                                                  <option value="14.5">14.5</option>
                                                  <option value="15">15</option>
                                                  <option value="15.5">15.5</option>
                                                  <option value="16">16</option>
                                              </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>3.</td>
                                          <td>Клиент 4</td>
                                          <td style="width: 82px; text-align: right;">
                                              <select class="form-control-off" name="work_hours_of_day">
                                                  <option value="0">0</option>
                                                  <option value="0.5">0.5</option>
                                                  <option value="1">1</option>
                                                  <option value="1.5">1.5</option>
                                                  <option value="2">2</option>
                                                  <option value="2.5" selected>2.5</option>
                                                  <option value="3">3</option>
                                                  <option value="3.5">3.5</option>
                                                  <option value="4">4</option>
                                                  <option value="4.5">4.5</option>
                                                  <option value="5">5</option>
                                                  <option value="5.5">5.5</option>
                                                  <option value="6">6</option>
                                                  <option value="6.5">6.5</option>
                                                  <option value="7">7</option>
                                                  <option value="7.5">7.5</option>
                                                  <option value="8">8</option>
                                                  <option value="8.5">8.5</option>
                                                  <option value="9">9</option>
                                                  <option value="9.5">9.5</option>
                                                  <option value="10">10</option>
                                                  <option value="10.5">10.5</option>
                                                  <option value="11">11</option>
                                                  <option value="11.5">11.5</option>
                                                  <option value="12">12</option>
                                                  <option value="12.5">12.5</option>
                                                  <option value="13">13</option>
                                                  <option value="13.5">13.5</option>
                                                  <option value="14">14</option>
                                                  <option value="14.5">14.5</option>
                                                  <option value="15">15</option>
                                                  <option value="15.5">15.5</option>
                                                  <option value="16">16</option>
                                              </select>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <span class="data-total"><i class="far fa-clock"></i> 8</span>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-12 py-3">
                            <h4>Если выбрана неделя:</h4>
                        </div>
                        <div class="col-lg-6">
                            <form class="card few-days d-flex flex-fill">
                                <div class="card-body pt-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-muted pb-1">
                                                Digital Strategist
                                            </div>
                                            <h2 class="lead"><b>Nicole Pearson</b></h2>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:+80012122352">+(800) 121-223-22</a></li>
                                                <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:user.email@email.com">user.email@email.com</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center"><img alt="user-avatar" class="user-avatar img-circle img-fluid" src="{{ asset('vendor/adminlte/dist/img/user1-128x128.jpg') }}"></div>
                                    </div>
                                </div><div class="card-body p-0">
                                    <table class="table table-sm client-table">
                                        <tbody>
                                          <tr>
                                            <td style="width: 10px">1.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">10</td>
                                          </tr>
                                          <tr>
                                            <td>2.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">20</td>
                                          </tr>
                                          <tr>
                                            <td>3.</td>
                                            <td>Клиент 3</td>
                                            <td style="width: 80px; text-align: right;">15</td>
                                          </tr>
                                          <tr>
                                            <td>4.</td>
                                            <td>Клиент 4</td>
                                            <td style="width: 80px; text-align: right;">7</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </table>
                                  </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <span class="data-total"><i class="far fa-clock"></i> 31</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <form class="card bg-white d-flex flex-fill">
                                <div class="card-body pt-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-muted pb-1">
                                                Digital Strategist
                                            </div>
                                            <h2 class="lead"><b>Nicole Pearson</b></h2>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:+80012122352">+(800) 121-223-22</a></li>
                                                <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:user.email@email.com">user.email@email.com</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center"><img alt="user-avatar" class="user-avatar img-circle img-fluid" src="{{ asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}"></div>
                                    </div>
                                </div><div class="card-body p-0">
                                    <table class="table table-sm client-table">
                                        <tbody>
                                          <tr>
                                            <td style="width: 10px">1.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">10</td>
                                          </tr>
                                          <tr>
                                            <td>2.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">20</td>
                                          </tr>
                                          <tr>
                                            <td>3.</td>
                                            <td>Клиент 3</td>
                                            <td style="width: 80px; text-align: right;">15</td>
                                          </tr>
                                          <tr>
                                            <td>4.</td>
                                            <td>Клиент 4</td>
                                            <td style="width: 80px; text-align: right;">7</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </table>
                                  </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <span class="data-total"><i class="far fa-clock"></i> 42</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <form class="card many-days d-flex flex-fill">
                                <div class="card-body pt-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-muted pb-1">
                                                Digital Strategist
                                            </div>
                                            <h2 class="lead"><b>Nicole Pearson</b></h2>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:+80012122352">+(800) 121-223-22</a></li>
                                                <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:user.email@email.com">user.email@email.com</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center"><img alt="user-avatar" class="user-avatar img-circle img-fluid" src="{{ asset('vendor/adminlte/dist/img/user-woman.jpg') }}"></div>
                                    </div>
                                </div><div class="card-body p-0">
                                    <table class="table table-sm client-table">
                                        <tbody>
                                          <tr>
                                            <td style="width: 10px">1.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">10</td>
                                          </tr>
                                          <tr>
                                            <td>2.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">20</td>
                                          </tr>
                                          <tr>
                                            <td>3.</td>
                                            <td>Клиент 3</td>
                                            <td style="width: 80px; text-align: right;">15</td>
                                          </tr>
                                          <tr>
                                            <td>4.</td>
                                            <td>Клиент 4</td>
                                            <td style="width: 80px; text-align: right;">7</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </table>
                                  </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <span class="data-total"><i class="far fa-clock"></i> 48</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <form class="card bg-white d-flex flex-fill">
                                <div class="card-body pt-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-muted pb-1">
                                                Digital Strategist
                                            </div>
                                            <h2 class="lead"><b>Nicole Pearson</b></h2>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:+80012122352">+(800) 121-223-22</a></li>
                                                <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:user.email@email.com">user.email@email.com</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center"><img alt="user-avatar" class="user-avatar img-circle img-fluid" src="{{ asset('vendor/adminlte/dist/img/no-usericon.svg') }}"></div>
                                    </div>
                                </div><div class="card-body p-0">
                                    <table class="table table-sm client-table">
                                        <tbody>
                                          <tr>
                                            <td style="width: 10px">1.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">10</td>
                                          </tr>
                                          <tr>
                                            <td>2.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">20</td>
                                          </tr>
                                          <tr>
                                            <td>3.</td>
                                            <td>Клиент 3</td>
                                            <td style="width: 80px; text-align: right;">15</td>
                                          </tr>
                                          <tr>
                                            <td>4.</td>
                                            <td>Клиент 4</td>
                                            <td style="width: 80px; text-align: right;">7</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </table>
                                  </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <span class="data-total"><i class="far fa-clock"></i> 40</span>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-12 py-3">
                            <h4>Если выбран месяц:</h4>
                        </div>
                        <div class="col-lg-6">
                            <form class="card few-days d-flex flex-fill">
                                <div class="card-body pt-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-muted pb-1">
                                                Digital Strategist
                                            </div>
                                            <h2 class="lead"><b>Nicole Pearson</b></h2>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:+80012122352">+(800) 121-223-22</a></li>
                                                <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:user.email@email.com">user.email@email.com</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center"><img alt="user-avatar" class="user-avatar img-circle img-fluid" src="{{ asset('vendor/adminlte/dist/img/user1-128x128.jpg') }}"></div>
                                    </div>
                                </div><div class="card-body p-0">
                                    <table class="table table-sm client-table">
                                        <tbody>
                                          <tr>
                                            <td style="width: 10px">1.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">10</td>
                                          </tr>
                                          <tr>
                                            <td>2.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">20</td>
                                          </tr>
                                          <tr>
                                            <td>3.</td>
                                            <td>Клиент 3</td>
                                            <td style="width: 80px; text-align: right;">15</td>
                                          </tr>
                                          <tr>
                                            <td>4.</td>
                                            <td>Клиент 4</td>
                                            <td style="width: 80px; text-align: right;">7</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </table>
                                  </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <span class="data-total"><i class="far fa-clock"></i> 82</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <form class="card bg-white d-flex flex-fill">
                                <div class="card-body pt-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-muted pb-1">
                                                Digital Strategist
                                            </div>
                                            <h2 class="lead"><b>Nicole Pearson</b></h2>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:+80012122352">+(800) 121-223-22</a></li>
                                                <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:user.email@email.com">user.email@email.com</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center"><img alt="user-avatar" class="user-avatar img-circle img-fluid" src="{{ asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}"></div>
                                    </div>
                                </div><div class="card-body p-0">
                                    <table class="table table-sm client-table">
                                        <tbody>
                                          <tr>
                                            <td style="width: 10px">1.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">10</td>
                                          </tr>
                                          <tr>
                                            <td>2.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">20</td>
                                          </tr>
                                          <tr>
                                            <td>3.</td>
                                            <td>Клиент 3</td>
                                            <td style="width: 80px; text-align: right;">15</td>
                                          </tr>
                                          <tr>
                                            <td>4.</td>
                                            <td>Клиент 4</td>
                                            <td style="width: 80px; text-align: right;">7</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </table>
                                  </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <span class="data-total"><i class="far fa-clock"></i> 156</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <form class="card many-days d-flex flex-fill">
                                <div class="card-body pt-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-muted pb-1">
                                                Digital Strategist
                                            </div>
                                            <h2 class="lead"><b>Nicole Pearson</b></h2>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:+80012122352">+(800) 121-223-22</a></li>
                                                <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:user.email@email.com">user.email@email.com</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center"><img alt="user-avatar" class="user-avatar img-circle img-fluid" src="{{ asset('vendor/adminlte/dist/img/user-woman.jpg') }}"></div>
                                    </div>
                                </div><div class="card-body p-0">
                                    <table class="table table-sm client-table">
                                        <tbody>
                                          <tr>
                                            <td style="width: 10px">1.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">10</td>
                                          </tr>
                                          <tr>
                                            <td>2.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">20</td>
                                          </tr>
                                          <tr>
                                            <td>3.</td>
                                            <td>Клиент 3</td>
                                            <td style="width: 80px; text-align: right;">15</td>
                                          </tr>
                                          <tr>
                                            <td>4.</td>
                                            <td>Клиент 4</td>
                                            <td style="width: 80px; text-align: right;">7</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </table>
                                  </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <span class="data-total"><i class="far fa-clock"></i> 192</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <form class="card bg-white d-flex flex-fill">
                                <div class="card-body pt-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="text-muted pb-1">
                                                Digital Strategist
                                            </div>
                                            <h2 class="lead"><b>Nicole Pearson</b></h2>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:+80012122352">+(800) 121-223-22</a></li>
                                                <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:user.email@email.com">user.email@email.com</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center"><img alt="user-avatar" class="user-avatar img-circle img-fluid" src="{{ asset('vendor/adminlte/dist/img/no-usericon.svg') }}"></div>
                                    </div>
                                </div><div class="card-body p-0">
                                    <table class="table table-sm client-table">
                                        <tbody>
                                          <tr>
                                            <td style="width: 10px">1.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">10</td>
                                          </tr>
                                          <tr>
                                            <td>2.</td>
                                            <td>Клиент 2</td>
                                            <td style="width: 80px; text-align: right;">20</td>
                                          </tr>
                                          <tr>
                                            <td>3.</td>
                                            <td>Клиент 3</td>
                                            <td style="width: 80px; text-align: right;">15</td>
                                          </tr>
                                          <tr>
                                            <td>4.</td>
                                            <td>Клиент 4</td>
                                            <td style="width: 80px; text-align: right;">7</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </table>
                                  </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <span class="data-total"><i class="far fa-clock"></i> 162</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
