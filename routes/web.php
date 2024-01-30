<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketRefundController;
use App\Http\Controllers\UmrahController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('agent/view', function () {
    return app(AgentController::class)->index();
})->name('agent.view');
Route::post('/addagent', [AgentController::class, 'store'])->name('addagent.store');
Route::get('/agent/edit/{id}', [AgentController::class, 'edit'])->name('agent.edit');
Route::post('/agent/update/{id}', [AgentController::class, 'update'])->name('agent.update');
Route::get('/agent/delete/{id}', [AgentController::class, 'delete'])->name('agent.delete');

Route::get('/supplier/view', function () {
    return app(SupplierController::class)->index();
})->name('supplier.view');
Route::post('/addsupplier', [SupplierController::class, 'store'])->name('addsupplier.store');
Route::get('/supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::post('/supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
Route::get('/supplier/delete/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');

Route::get('type/view', function () {
    return app(TypeController::class)->index();
})->name('type.view');
Route::post('/addtype', [TypeController::class, 'store'])->name('addtype.store');
Route::get('/type/edit/{id}', [TypeController::class, 'edit'])->name('type.edit');
Route::post('/type/update/{id}', [TypeController::class, 'update'])->name('type.update');
Route::get('/type/delete/{id}', [TypeController::class, 'delete'])->name('type.delete');

Route::get('/order/view', function () {
    return app(OrderController::class)->index();
})->name('order.view');
Route::post('/addorder', [OrderController::class, 'store'])->name('addorder.store');
Route::get('/order/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
Route::post('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');
Route::get('/order/delete/{id}', [OrderController::class, 'delete'])->name('order.delete');

Route::get('/ticket/view', function () {
    return app(TicketController::class)->index();
})->name('ticket.view');
Route::post('/addticket', [TicketController::class, 'store'])->name('addticket.store');
Route::get('/ticket/edit/{id}', [TicketController::class, 'edit'])->name('ticket.edit');
Route::post('/ticket/update/{id}', [TicketController::class, 'update'])->name('ticket.update');
Route::get('/ticket/delete/{id}', [TicketController::class, 'delete'])->name('ticket.delete');

// Ticket Refund
Route::get('/refund_ticket/view', function () {
    return app(TicketRefundController::class)->index();
})->name('refund_ticket.view');
Route::post('/add_refund_ticket', [TicketRefundController::class, 'store'])->name('refund.store');
Route::get('/refund_ticket/edit/{id}', [TicketRefundController::class, 'edit'])->name('refund_ticket.edit');
Route::post('/refund_ticket/update/{id}', [TicketRefundController::class, 'update'])->name('refund_ticket.update');
Route::get('/refund_ticket/delete/{id}', [TicketRefundController::class, 'delete'])->name('refund_ticket.delete');

Route::get('/deportee/view', function () {
    return app(TicketController::class)->deportee();
})->name('deportee.view');

Route::get('/report/view', function () {
    return app(ReportController::class)->index();
})->name('report.view');
Route::post('/generate-report', [ReportController::class, 'generate'])->name('generate.report');

Route::get('/umrah/view', function () {
    return app(UmrahController::class)->index();
})->name('umrah.view');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
