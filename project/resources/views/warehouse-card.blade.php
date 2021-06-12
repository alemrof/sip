<div class="card border-dark" id="popup" style="width: 18rem;">
    <div class="card-header bg-dark text-white">
        <button type="button" class="close" id="closer">
            <span aria-hidden="true" class="text-white">&times;</span>
        </button>
        <ul class="nav nav-tabs card-header-tabs" id="warehouse-card-list" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" href="#description" role="tab" aria-controls="description" aria-selected="true">Opis</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#hours" role="tab" aria-controls="hours" aria-selected="false">Godziny</a>
          </li>
        </ul>
    </div>
    <div class="card-body">
        <span class="align-middle"><a href="" id="warehouse-name">Nazwa składu</a></span>
        <div class="tab-content mt-3">
        {{-- Description --}}
            <div class="tab-pane active" id="description" role="tabpanel">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" id="warehouse-company">Sieć sklepów</li>
                    <li class="list-group-item" id="warehouse-address">Adres XXX, 00-000 Miejscowość</li>
                    <li class="list-group-item" id="warehouse-location">Położenie</li>
                </ul>
            </div>
        {{-- Hours --}}
            <div class="tab-pane" id="hours" role="tabpanel" aria-labelledby="hours-tab">
                <h5 class="card-title">Godziny otwarcia:</h5>
                <table>
                    <tr>
                        <td>poniedziałek</td>
                        <td id="monday-hours">00:00-00:00</td>
                    </tr>
                    <tr>
                        <td>wtorek</td>
                        <td id="tuesday-hours">00:00-00:00</td>
                    </tr>
                    <tr>
                        <td>środa</td>
                        <td id="wednesday-hours">00:00-00:00</td>
                    </tr>
                    <tr>
                    <td>czwartek</td>
                        <td id="thursday-hours">00:00-00:00</td>
                    </tr>
                    <tr>
                        <td>piątek</td>
                        <td id="friday-hours">00:00-00:00</td>
                    </tr>
                    <tr>
                        <td>sobota</td>
                        <td id="saturday-hours">00:00-00:00</td>
                    </tr>
                    <tr>
                        <td>niedziela</td>
                        <td id="sunday-hours">00:00-00:00</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <a href="" class="btn btn-light btn-sm border-dark" id="route-link"><i class="fas fa-route"></i></a>
            <a href="" class="btn btn-light btn-sm border-dark" id="offer-link">Oferta</a>
            @auth
                @if (auth()->user()->isAdmin())
                    <a href="" class="btn btn-light btn-sm border-dark" id="edit-link"><i class="fas fa-edit"></i></a>
                    <a href="" class="btn btn-light btn-sm border-dark" id="editMap-link"><i class="fas fa-map-marked"></i></a>
                @endif
            @endauth
        </div>
        <div class="d-flex justify-content-between pb-0" id="popupArrows">
            <a href=""><i class="fas fa-long-arrow-alt-left fa-3x" id="popupPreviousWarehouse"></i></a>
            <a href=""><i class="fas fa-long-arrow-alt-right fa-3x" id="popupNextWarehouse"></i></a>
        </div>
    </div>
</div>
