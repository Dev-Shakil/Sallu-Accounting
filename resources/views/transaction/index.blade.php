<x-app-layout>
   
        <div class="container mt-5">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <h1 class="mb-4">Add Transaction Method</h1>
    
            <div class="addagent">
                <form action="/transaction_add" method="post">
                    @csrf <!-- Add this line to include CSRF protection in Laravel -->
                    <div class="row">
                        <div class="form-group col">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                        </div>
        
                     
                    </div>
                  
                    <div class="row">
                        <div class="form-group col">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Enter a description"></textarea>
                        </div>
                    </div>
        
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
    
            <div class="allagents">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Serial</th>
                            <th scope="col">Name</th>
                         
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $index => $transaction)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $transaction->name }}</td>
                               
                                <td>{{ $transaction->description }}</td>
                                <td>
                                    <a href="{{ route('transaction.edit', ['id' => encrypt($transaction->id)]) }}" class="btn btn-primary">Edit</a>
                                    <a href="{{ route('transaction.delete', ['id' => $transaction->id]) }}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
    
        </div>
</x-app-layout>