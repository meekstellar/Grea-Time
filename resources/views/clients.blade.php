@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    Клиенты
                </h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="#" class="btn btn-success btn-sm"><i class="fas fa-file-pdf"></i> &nbsp;PDF</a>
                <a href="#" class="btn btn-success btn-sm"><i class="fas fa-file-alt"></i> &nbsp;XLS</a>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="alert alert-danger" role="alert">
                <h3>Страница в разработке</h3>
            </div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form class="row">
                <div class="col-md-4">
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
                                <label><i class="fa fa-building" aria-hidden="true"></i> Клиенты:</label>
                                <select class="select2" multiple="multiple" data-placeholder="Выберите клиента" style="width: 100%;">
                                    <option>Клиент 1</option>
                                    <option>Клиент 2</option>
                                    <option>Клиент 3</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Применить</button>
                            </div>
                        </div>
                      </div>
                </div>
                <div class="col-md-8">
                    <div class="col-12 py-3">
                        <h4>Если выбрана неделя:</h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                  <h3 class="card-title"><b>Клиент 1</b></h3>
                                  <span class="data-total"><i class="far fa-clock"></i> 24</span>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                  <table class="table table-sm client-table">
                                    <tbody>
                                      <tr>
                                        <td style="width: 10px">1.</td>
                                        <td>Сотрудник 2</td>
                                        <td style="width: 80px; text-align: right;">10</td>
                                      </tr>
                                      <tr>
                                        <td>2.</td>
                                        <td>Сотрудник 2</td>
                                        <td style="width: 80px; text-align: right;">20</td>
                                      </tr>
                                      <tr>
                                        <td>3.</td>
                                        <td>Сотрудник 3</td>
                                        <td style="width: 80px; text-align: right;">15</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                  <h3 class="card-title"><b>Клиент 2</b></h3>
                                  <span class="data-total"><i class="far fa-clock"></i> 24</span>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                  <table class="table table-sm client-table">
                                    <tbody>
                                      <tr>
                                        <td style="width: 10px">1.</td>
                                        <td>Сотрудник 2</td>
                                        <td style="width: 80px; text-align: right;">10</td>
                                      </tr>
                                      <tr>
                                        <td>2.</td>
                                        <td>Сотрудник 2</td>
                                        <td style="width: 80px; text-align: right;">20</td>
                                      </tr>
                                      <tr>
                                        <td>3.</td>
                                        <td>Сотрудник 3</td>
                                        <td style="width: 80px; text-align: right;">15</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                  <h3 class="card-title"><b>Клиент 3</b></h3>
                                  <span class="data-total"><i class="far fa-clock"></i> 24</span>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                  <table class="table table-sm client-table">
                                    <tbody>
                                      <tr>
                                        <td style="width: 10px">1.</td>
                                        <td>Сотрудник 2</td>
                                        <td style="width: 80px; text-align: right;">10</td>
                                      </tr>
                                      <tr>
                                        <td>2.</td>
                                        <td>Сотрудник 2</td>
                                        <td style="width: 80px; text-align: right;">20</td>
                                      </tr>
                                      <tr>
                                        <td>3.</td>
                                        <td>Сотрудник 3</td>
                                        <td style="width: 80px; text-align: right;">15</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-12 py-3">
                            <h4>Если выбран месяц:</h4>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                  <h3 class="card-title"><b>Клиент 1</b></h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                  <table class="table table-sm client-table">
                                    <tbody>
                                      <tr>
                                        <td style="width: 10px">1.</td>
                                        <td>Сотрудник 2</td>
                                        <td style="width: 80px; text-align: right;">300000</td>
                                      </tr>
                                      <tr>
                                        <td>2.</td>
                                        <td>Сотрудник 2</td>
                                        <td style="width: 80px; text-align: right;">2300</td>
                                      </tr>
                                      <tr>
                                        <td>3.</td>
                                        <td>Сотрудник 3</td>
                                        <td style="width: 80px; text-align: right;">2300</td>
                                      </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" style="border-top: 2px solid #dfdfdf;">ИТОГО Себестоимость</td>
                                            <td style="border-top: 2px solid #dfdfdf; text-align: right;">129500</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">OPEX (35%)</td>
                                            <td style="text-align: right;">105000</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">ГОНОРАР</td>
                                            <td style="text-align: right;">300000</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">ПРИБЫЛЬ</td>
                                            <td style="text-align: right; font-weight: bold;">65500</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">МАРЖИНАЛЬНОСТЬ</td>
                                            <td style="text-align: right; font-weight: bold;">22%</td>
                                        </tr>
                                    </tfoot>
                                  </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                  <h3 class="card-title"><b>Клиент 2</b></h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                  <table class="table table-sm client-table">
                                    <tbody>
                                      <tr>
                                        <td style="width: 10px">1.</td>
                                        <td>Сотрудник 2</td>
                                        <td style="width: 80px; text-align: right;">300000</td>
                                      </tr>
                                      <tr>
                                        <td>2.</td>
                                        <td>Сотрудник 2</td>
                                        <td style="width: 80px; text-align: right;">2300</td>
                                      </tr>
                                      <tr>
                                        <td>3.</td>
                                        <td>Сотрудник 3</td>
                                        <td style="width: 80px; text-align: right;">2300</td>
                                      </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" style="border-top: 2px solid #dfdfdf;">ИТОГО Себестоимость</td>
                                            <td style="border-top: 2px solid #dfdfdf; text-align: right;">129500</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">OPEX (35%)</td>
                                            <td style="text-align: right;">105000</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">ГОНОРАР</td>
                                            <td style="text-align: right;">300000</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">ПРИБЫЛЬ</td>
                                            <td style="text-align: right; font-weight: bold;">65500</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">МАРЖИНАЛЬНОСТЬ</td>
                                            <td style="text-align: right; font-weight: bold;">22%</td>
                                        </tr>
                                    </tfoot>
                                  </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                  <h3 class="card-title"><b>Клиент 3</b></h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                  <table class="table table-sm client-table">
                                    <tbody>
                                      <tr>
                                        <td style="width: 10px">1.</td>
                                        <td>Сотрудник 2</td>
                                        <td style="width: 80px; text-align: right;">300000</td>
                                      </tr>
                                      <tr>
                                        <td>2.</td>
                                        <td>Сотрудник 2</td>
                                        <td style="width: 80px; text-align: right;">2300</td>
                                      </tr>
                                      <tr>
                                        <td>3.</td>
                                        <td>Сотрудник 3</td>
                                        <td style="width: 80px; text-align: right;">2300</td>
                                      </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" style="border-top: 2px solid #dfdfdf;">ИТОГО Себестоимость</td>
                                            <td style="border-top: 2px solid #dfdfdf; text-align: right;">129500</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">OPEX (35%)</td>
                                            <td style="text-align: right;">105000</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">ГОНОРАР</td>
                                            <td style="text-align: right;">300000</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">ПРИБЫЛЬ</td>
                                            <td style="text-align: right; font-weight: bold;">65500</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">МАРЖИНАЛЬНОСТЬ</td>
                                            <td style="text-align: right; font-weight: bold;">22%</td>
                                        </tr>
                                    </tfoot>
                                  </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>









                </div>
            </form>
        </div>
    </section>

@endsection
