@extends('layouts.adm')

@section('content')
<div class="admin-container">
    <h1 class="admin-title wow fadeInDown">Управление ссылками сайта</h1>
    
    @if(session('success'))
        <div class="admin-alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="admin-card wow fadeInUp">
        <div class="header-section flex-between">
            <h5>Редактирование ссылок и контактов</h5>
        </div>
        
        <form action="{{ route('admin.site-links.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="admin-table-wrapper">
                <table class="admin-table" id="linksTable">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Значение</th>
                            <th>Описание</th>
                            <th>Тип</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siteLinks as $link)
                        <tr>
                            <td><strong>{{ $link->key }}</strong></td>
                            <td>
                                <input type="text" name="links[{{ $link->id }}]" value="{{ $link->value }}" class="admin-input " style="width: 100%;">
                            </td>
                            <td>{{ $link->description }}</td>
                            <td>
                                <span class="admin-badge 
                                    {{ $link->type == 'phone' ? 'badge-primary' : '' }}
                                    {{ $link->type == 'email' ? 'badge-info' : '' }}
                                    {{ $link->type == 'link' ? 'badge-success' : '' }}
                                ">
                                    {{ $link->type }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 text-right">
                <button type="submit" class="admin-btn">Сохранить изменения</button>
            </div>
        </form>
        
        
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#linksTable').DataTable({
            pageLength: 10,
            responsive: true,
            dom: 'rt<"bottom"lp><"clear">',
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/ru.json'
            }
        });
    });
</script>
@endsection
