@extends('layout')

@section('menu')
<span class="navbar-brand mb-0 h1">{{ getenv('APP_NAME') }}</span>
<span class="navbar-brand mr-0 h1">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-three-dots-vertical"
        viewBox="0 0 16 16" id="toggle">
        <path
            d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
    </svg>
</span>
@endsection

@section('content')
<div class="container">
    <div class="card option mb-3" style="display: none;">
        <div class="p-2">
            <span class="btn-option mr-3">
                <input type="checkbox" id="check-all" class="ml-2" style="transform: scale(1.2); margin-right: 2px;">
                <label for="check-all" class="m-0 p-0">All</label>
            </span>
            <span class="btn-option mr-3" id="delete">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash"
                    viewBox="0 0 16 16">
                    <path
                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                    <path fill-rule="evenodd"
                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                </svg>
                Delete
            </span>
            <div class="d-inline w-100">
                <span class="btn-search" id="search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                    <input type="text" class="input-search" placeholder="Search..." id="input-search">
                </span>
            </div>
        </div>
    </div>
    @if(session('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-index">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
            onclick="document.getElementById('alert-index').style.display = 'none';">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @foreach ($notes as $note)
    <div class="d-flex flex-row" id="row-{{$note->id}}">
        <div class="align-top text-center d-none hide-show-content" data-content="div-checkbox-option">
            <input type="checkbox" class="checkbox-option hide-show-content" data-id="{{$note->id}}" data-option="true"
                id="checkbox-option-{{$note->id}}" style="transform: scale(1.3); margin-top: 1px">
        </div>
        <div class="w-100">
            <div class="card card-click mb-3" onclick="link('{{$note->id}}')">
                <div class="card-body" data-id="{{$note->id}}">
                    <h5>{{ $note->title }}</h5>
                    <span class="cutoff-text">{{ strip_tags($note->body) }}</span>
                    <br>
                    <span class="date-display">{{ \Carbon\Carbon::make($note->updated_at)->format("d/m/Y H:i:s")
                        }}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="container sticky-bottom hide-show-content" data-content="footer">
    <div class="card mb-3 div-add">
        <div class="p-2" onclick="addNote()">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#1B3265" class="bi bi-plus"
                viewBox="0 0 16 16">
                <path
                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
            </svg>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const elToggle  = document.querySelector("#toggle");
    const elChAll   = document.querySelector("#check-all");
    const elDelete  = document.querySelector("#delete");
    const elSearch  = document.querySelector("#input-search");
    const elOption  = document.querySelector(".option");
    const elContent = document.getElementsByClassName("hide-show-content");
    const elChBox   = document.getElementsByClassName("checkbox-option");
    const elTd      = document.getElementsByClassName("d-none");
    const elCardB   = document.getElementsByClassName("card-body");
    
    elSearch.addEventListener("keyup", (e) => {
        searchNote(elSearch)
    });

    function searchNote(el) 
    {
        const search = el.value.toLowerCase()
        Array.from(elCardB).forEach(element => {
            let text = ''
            text += element.children[0].innerHTML
            text += element.children[1].innerHTML
            text += element.children[3].innerHTML
            const matching = text.toLowerCase().match(search)
            const id = element.getAttribute('data-id')
            const row = document.querySelector(`#row-${id}`)
            const checkbox_option = document.querySelector(`#checkbox-option-${id}`)
            if (matching == null) {
                row.classList.remove("d-flex")
                row.classList.add("d-none")
                checkbox_option.setAttribute('data-option', false)
            } else {
                row.classList.remove("d-none")
                row.classList.add("d-flex")
                checkbox_option.setAttribute('data-option', true)
            }
        });
    }

    elToggle.addEventListener("click", () => {
        elOption.classList.toggle("option-show");
        elSearch.value = null
        searchNote(elSearch)
        Array.from(elContent).forEach(element => {
            if (element.getAttribute('data-content') == "footer") {
                element.classList.toggle("hide-el");
            } else if (element.getAttribute('data-content') == "div-checkbox-option") {
                element.classList.toggle("d-inline");
            } else {
                element.classList.toggle("show-el");
            }
        });
    });

    elChAll.addEventListener("click", () => {
        checkAll()
    });

    function checkAll(withDelete = false)
    {
        if (withDelete) {
            Array.from(elChBox).forEach(element => {
                if (element.getAttribute('data-option') == 'false') element.checked = false
            });
            return
        }
        if (elChAll.checked) {
            Array.from(elChBox).forEach(element => {
                if (element.getAttribute('data-option') == 'true') {
                    element.checked = true
                } else {
                    element.checked = false
                } 
            });
        } else {
            Array.from(elChBox).forEach(element => {
                element.checked = false
            });
        }
    }

    elDelete.addEventListener("click", () => {
        searchNote(elSearch)
        checkAll(true)
        let arr = []
        Array.from(elChBox).forEach(element => {
            element.checked && arr.push(element.getAttribute('data-id'))
        });
        if (arr.length > 0) {
            if (confirm(`Apakah anda yakin ingin menghapus ${arr.length} ini?`) == true) {
                const Http  = new XMLHttpRequest();
                const url   = location.href+`note/delete`;
                const data  = JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    ids: arr
                });
                Http.open("DELETE", url, true);
                Http.setRequestHeader('Content-type','application/json;charset=UTF-8');
                Http.send(data);
                Http.onload = function () {
                    if (this.responseText == true) {
                        window.location.reload()
                    }
                };
            }
        }
    });
    
    function addNote()
    {
        location.href = location.href+'note/new';
    }

    function link(id)
    {
        location.href = location.href+`note/${id}`;
    }
</script>
@endsection