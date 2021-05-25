<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
                <div class="row ">
                <div class="col-md-4">
            <br>      
                        @if(isset($conutries))
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Transport Type</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($conutries) > 0)
                                @foreach($conutries as $conutrie)
                                <tr>
                                    <td>{{$conutrie->id}}</td>
                                    <td>{{$conutrie->name}}</td>
                                    
                                   
                                </tr>
                                @endforeach

                                @else
                                <tr><td> no result found!</td></tr>
                                @endif
                            </tbody>
                        </table>

                        @endif()
            </div>
        </div>
    </div>
</x-app-layout>