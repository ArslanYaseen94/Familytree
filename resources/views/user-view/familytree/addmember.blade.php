@extends('layouts.user.app')
@section('content')
@php
$value = \App\Models\FamilyTree::where(['id' => $id])->get();
$types = \App\Models\Types::where(['is_active' => 1])->get();
$generations = \App\Models\Generations::where(['is_active' => 1])->get();
@endphp
<style>
    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    .form-avatar {
        margin-top: 1em;
    }

    .form-avatar .form-inline {
        display: flex;
        flex-wrap: wrap;
        gap: 0em;
    }

    .form-avatar .form-group {
        margin: 0;
        position: relative;
        cursor: pointer;
        width: 61px;
        /* Adjust size as needed */
    }

    .form-avatar .form-group img {
        width: 100%;
        height: auto;
        border: 2px solid transparent;
        border-radius: 50%;
        transition: border-color 0.3s ease;
    }

    .form-avatar .form-group input[type="radio"] {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .form-avatar .form-group input[type="radio"]:checked+label img {
        border-color: #007bff;
        /* Change this color to highlight the selected image */
    }

    .form-avatar .form-group label {
        display: block;
        padding: 5px;
        border-radius: 50%;
        border: 2px solid transparent;
        transition: border-color 0.3s ease;
    }

    .form-avatar .form-group input[type="radio"]:checked+label {
        border-color: #007bff;
        /* Change this color to match the selected state */
    }

    .form-label.tt {
        display: flex;
        align-items: center;
        text-align: center;
        position: relative;
        margin: 1em 0;
    }

    .form-label.tt::before,
    .form-label.tt::after {
        content: '';
        flex: 1;
        border-top: 1px solid #ccc;
        /* Change this color and style as needed */
        margin: 0 1em;
    }


    #family-tree {
        position: relative;
        width: 90%;
        height: 75vh;
        /* Adjust as needed */
        overflow: hidden;
        border: 5px solid #0075ff;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        border-radius: 15px;
        cursor: grab;
        margin-left: 3rem
    }

    #family-tree::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('/assets/front-end/images/tree.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0.3;
        z-index: 0;
        border-radius: inherit;
    }

    #family-tree>* {
        position: relative;
        z-index: 1;
    }

    .node {
        cursor: pointer;
    }

    .link {
        fill: none;
        stroke: #555;
        stroke-width: 1.5px;
    }

    .node-container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .member-card,
    .partner-card {
        border: 2px solid var(--theme-color) !important;
        width: 120px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        overflow: hidden;
        text-align: center;
        position: relative;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    }

    .partner-card .avatar-wrapper {
        width: 60px;
        height: 60px;
        margin: 8px auto 4px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid var(--theme-color);
    }

    .avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 2px solid var(--theme-color) !important;
        margin: 8px auto 4px;
        overflow: hidden;
        display: block;
        position: relative;
    }

    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .card-details {
        padding: 2px 6px 4px;
        background: rgba(255, 255, 255, 0.97);
    }

    .card-details h4 {
        font-size: 10px !important;
        line-height: 1.3;
        margin: 0 0 2px 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 110px;
    }

    .card-details p {
        font-size: 8px !important;
        line-height: 1.2;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #555;
    }

    .icons-container {
        display: flex;
        justify-content: center;
        gap: 6px;
        padding: 3px 4px 6px;
        background: rgba(255, 255, 255, 0.97);
    }

    .icons-container a {
        font-size: 11px;
        color: #555;
    }

    .icons-container a:hover {
        color: var(--theme-color);
    }

    /* Responsive Adjustments */
    @media (max-width: 1200px) {

        .member-card,
        .partner-card {
            height: 10vh;
            width: 10vw;
        }
    }

    @media (max-width: 992px) {

        .member-card,
        .partner-card {
            height: 8vh;
            width: 8vw;
        }
    }

    @media (max-width: 768px) {

        .member-card,
        .partner-card {
            height: 6vh;
            width: 6vw;
        }
    }

    @media (max-width: 576px) {

        .member-card,
        .partner-card {
            height: 5vh;
            width: 5vw;
        }

        #family-tree {
            height: 60vh;
        }
    }
</style>

<div class="main-content right-chat-active">
    <div class="middle-sidebar-bottom">
        <div class="middle-sidebar-left pe-0">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card w-100 d-block d-flex border-0"
                        style="padding: 10px; margin-bottom: 10px; background-color: transparent;">
                        <div class="card-body d-flex align-items-center" style="padding: 0;">
                            <h2 class="fw-700 mb-0 mt-0 font-md text-grey-900">{{ $value[0]['familyid'] }}'s Tree</h2>
                            <div class="search-form-2 ms-auto">
                                @if (!$hasMembers)
                                <a href="javascript:void(0)"
                                    class="d-none d-lg-block bg-success text-white font-xsssss text-uppercase fw-700 ls-3"
                                    style="padding: 12px;border-radius: 1rem !important;font-size: 13px !important;"
                                    data-toggle="modal" data-target="#addnewtree">New Member</a>
                                @else
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="family-tree" class="tree"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- main content -->
@endsection
<div class="modal fade" id="addnewtree" tabindex="-1" role="dialog" aria-labelledby="addnewtreeLabel"
    aria-hidden="true" style="display:none">
    <div class="modal-dialog" role="document" style="max-width: 45%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="fw-700 mb-0 mt-0 font-md text-grey-900" id="addnewtreeLabel">{{ __('messages.Create FamilyTree') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route("user.addmember.store") }}" enctype="multipart/form-data" method="post">
                @csrf
                <div id="form-error" class="alert alert-danger light alert-dismissible fade show" style="display:none;">
                </div>
                <div id="form-success" class="alert alert-success light alert-dismissible fade show"
                    style="display:none;"></div>

                <div class="modal-body">
                    <div class="">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                    aria-selected="true">{{ __('messages.Personal') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                    type="button" role="tab" aria-controls="profile"
                                    aria-selected="false">{{ __('messages.Contact') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="bio-tab" data-bs-toggle="tab" data-bs-target="#messages"
                                    type="button" role="tab" aria-controls="messages"
                                    aria-selected="false">{{ __('messages.Biographical') }}</button>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <br>
                            <div role="tabpanel" class="tab-pane active" id="home">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label mont-font fw-600 font-xsss">{{ __('messages.First Name:') }}</label>
                                        <input type="text" class="form-control" placeholder="{{ __('messages.Enter First Name') }}"
                                            name="firstname" required />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label mont-font fw-600 font-xsss">{{ __('messages.Last Name:') }}</label>
                                        <input type="text" class="form-control" placeholder="{{ __('messages.Enter Last Name') }}"
                                            name="lastname" required />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label mont-font fw-600 font-xsss">{{ __('messages.Email:') }}</label>
                                        <input type="email" class="form-control" placeholder="{{ __('messages.Enter Email') }}"
                                            name="email" />
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="form-label mont-font fw-600 font-xsss"> {{ __('messages.Relation Type:') }}</label>
                                        <select class="form-control" name="type">
                                            @foreach ($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="form-label mont-font fw-600 font-xsss"> {{ __('messages.Relation Type:') }}</label>
                                        <select class="form-control" name="type">
                                            @foreach ($generations as $generation)
                                            <option value="{{ $generation->id }}">{{ $generation->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col">
                                        <input class="choice" id="cb1" value="1" name="gender"
                                            type="radio" />
                                        <label class="tgl-btn mr-2" for="cb1">{{ __('messages.Female') }}</label>
                                        <input class="choice" id="cb2" value="2" name="gender"
                                            type="radio" />
                                        <label class="tgl-btn" for="cb2">{{ __('messages.Male') }}</label>
                                    </div>
                                    <div class="col">
                                        <div class="form-group mb-0">
                                            <input class="tgl tgl-light" id="cbs1" value="1"
                                                name="death" type="checkbox" checked />
                                            <label class="tgl-btn mt-3" for="cbs1"></label>
                                            <label class="form-label">{{ __('messages.This person is alive') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label">{{ __('messages.Village:') }}</label>
                                    <input type="text" name="village" placeholder="{{ __('messages.Enter Village') }}"
                                        class="form-control datepicker-here" />
                                </div><br>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="form-label">{{ __('messages.Birth Date:') }}</label>
                                        <input type="date" name="birthdate"
                                            class="form-control datepicker-here" data-position='top left' required />
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label">{{ __('messages.Marriage Date:') }}</label>
                                        <input type="date" name="marriagedate"
                                            class="form-control datepicker-here" data-position='top left' />
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label">{{ __('messages.Death Date:') }}</label>
                                        <input type="date" name="deathdate"
                                            class="form-control datepicker-here" data-position='top left' />
                                    </div>
                                </div><br>
                                <label class="form-label">{{ __('messages.Link this member to a user:') }}</label>
                                <input type="text" class="form-control" name="user" />
                                <div class="form-avatar">

                                    <div class="form-inline">
                                        @for ($i = 1; $i <= 18; $i++)
                                            <div class="form-group">
                                            <input type="radio" name="avatar" value="{{ $i }}"
                                                id="sradioe{{ $i }}" class="choice image">
                                            <label for="sradioe{{ $i }}"><b><img
                                                        src="{{ asset('assets/front-end/avatar/' . $i . '.jpg') }}" /></b></label>
                                    </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <div class="row">
                                <div class="col">
                                    <label class="form-label">{{ __('messages.Facebook:') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('messages.Enter Facebook') }}"
                                        name="facebook" />
                                </div>
                                <div class="col">
                                    <label class="form-label"> {{ __('messages.Twitter:') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('messages.Enter Twitter') }}"
                                        name="twitter" />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label">{{ __('messages.Instagram:') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('messages.Enter Instagram') }}"
                                        name="instagram" />
                                </div>

                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label">{{ __('messages.Home Tel:') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('messages.Enter Home Tel') }}"
                                        name="tel" />
                                </div>
                                <div class="col">
                                    <label class="form-label">{{ __('messages.Mobile:') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('messages.Enter Mobile') }}"
                                        name="mobile" />
                                </div>
                            </div>
                            <label class="form-label mt-2">{{ __('messages.Website:') }}</label>
                            <input type="text" class="form-control" placeholder="{{ __('messages.Enter Website') }}"
                                name="site" />
                        </div>
                        <div role="tabpanel" class="tab-pane" id="messages">
                            <div class="row">
                                <div class="col">
                                    <label class="form-label">{{ __('messages.Birth Place:') }}</label>
                                    <input class="form-control" type="text" placeholder="{{ __('messages.Enter Birth Place') }}"
                                        name="birthplace" />
                                </div>
                                <div class="col">
                                    <label class="form-label">{{ __('messages.Death Place:') }}</label>
                                    <input class="form-control" type="text" placeholder="{{ __('messages.Enter Death Place') }}"
                                        name="deathplace" />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label"> {{ __('messages.Home Town:') }}</label>
                                    <input class="form-control" type="text" placeholder="{{ __('messages.Enter Home Town') }}"
                                        name="home_town" />
                                </div>
                                <div class="col">
                                    <label class="form-label"> {{ __('messages.School:') }}</label>
                                    <input class="form-control" type="text" placeholder="{{ __('messages.Enter School') }}"
                                        name="school" />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label"> {{ __('messages.Background:') }}</label>
                                    <input class="form-control" type="text"
                                        placeholder="{{ __("messages.Enter Background Details") }}" name="background_details" />
                                </div>
                                <div class="col">
                                    <label class="form-label"> {{ __('messages.Business Info:') }}</label>
                                    <input class="form-control" type="text" placeholder="{{ __('messages.Enter Business Info') }}"
                                        name="business_info" />
                                </div>
                            </div>
                            <label class="form-label mt-2"> {{ __('messages.Profession:') }}</label>
                            <textarea class="form-control" name="profession" style="min-height: calc(2.5em + 0.75rem + 50px);"
                                placeholder="{{ __("messages.Enter Profession") }}"></textarea>
                            <label class="form-label mt-2"> {{ __('messages.Company:') }}</label>
                            <textarea class="form-control" name="company" style="min-height: calc(2.5em + 0.75rem + 50px);"
                                placeholder="{{ __("messages.Enter Company") }}"></textarea>
                            <label class="form-label mt-2">{{ __('messages.Interests:') }}</label>
                            <textarea class="form-control" name="interests" style="min-height: calc(2.5em + 0.75rem + 50px);"
                                placeholder="{{ __("messages.Enter Interests") }}"></textarea>
                            <label class="form-label mt-2"> {{ __('messages.Bio Notes:') }}</label>
                            <textarea class="form-control" name="bio" style="min-height: calc(2.5em + 0.75rem + 50px);"
                                placeholder="{{ __("messages.Enter Bio Notes") }}"></textarea>
                        </div>

                    </div>
                </div>
                <input type="hidden" name="family_id" id="family_id" value="{{ $value[0]['id'] }}">
                <input type="hidden" name="self_id" id="self_id" value="0">
        </div>
        <div class="modal-footer">
            <button type="submit"
                class="bg-current text-center text-white font-xsss fw-600 p-3 w175 rounded-3 d-inline-block">{{ __('messages.Save') }}</button>
        </div>
        </form>
    </div>
</div>
</div>
@section('scripts')
<script src="https://d3js.org/d3.v6.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const svg = d3.select("#family-tree").append("svg")
            .attr("width", "100%")
            .attr("height", "100%")
            .attr("viewBox", "0 0 2800 800")
            .attr("preserveAspectRatio", "xMidYMid meet")
            .call(d3.zoom().scaleExtent([0.5, 2]).on("zoom", zoom))
            .append("g")
            .attr("transform", "translate(40,40)");

        function zoom(event) {
            svg.attr("transform", event.transform);
        }

        fetch(`/user/get-family-tree/{{ $value[0]['id'] }}`)
            .then(response => response.json())
            .then(data => {
                if (!data || data.length === 0) {
                    document.getElementById("family-tree").innerHTML =
                        "<h3><br><br><center>No data available</center></h3>";
                    return;
                }

                const flatData = flattenData(data);
                const rootNode = buildTree(flatData);
                const root = d3.hierarchy(rootNode, d => d.children);

                const nodeCount = root.descendants().length;
                const treeWidth = Math.max(2800, nodeCount * 180);
                const treeHeight = Math.max(1200, root.height * 250 + 200);
                const treeLayout = d3.tree()
                    .size([treeWidth - 200, treeHeight - 200])
                    .separation((a, b) => a.parent === b.parent ? 1.5 : 2);
                treeLayout(root);

                // Create links using the adjusted line-drawing logic

                const link = svg.selectAll('.link')
                    .data(root.links())
                    .enter().append('path')
                    .attr('class', 'link')
                    .attr('d', d => {
                        const startX = d.source.x + 50;
                        const startY = d.source.y + 140; // Bottom of the card (foreignObject y:-10 + height:160 = 150, minus a bit)
                        const endX = d.target.x + 50;
                        const endY = d.target.y - 15; // Top of the child card

                        const midY = (startY + endY) / 2;

                        // Check if the target node is not a partner (type 2) or ex-partner (type 3)
                        if ((d.target.data.type !== 2 && d.target.data.type !== 3) && d.source
                            .children && d.source.children.length > 0) {
                            return `M${startX},${startY} V${midY} H${endX} V${endY}`;
                        } else {
                            return ""; // Return an empty string to avoid drawing the line
                        }
                    })
                    .attr("fill", "none")
                    .attr("stroke", "#ccc")
                    .attr("stroke-width", 2);
                const userHasImage = "{{ auth()->user()->has_image }}";
                const birthLabel = "{{ __('messages.Birth') }}";

                // Create nodes
                const node = svg.selectAll('g.node')
                    .data(root.descendants())
                    .enter().append('g')
                    .attr('class', 'node')
                    .attr('transform', d => `translate(${d.x},${d.y})`);

                node.append('foreignObject')
                    .attr('width', 130)
                    .attr('height', 160)
                    .attr('x', -15)
                    .attr('y', -10)
                    .html(d => `
                    <div class="partner-card">
                    ${
                    userHasImage === '1' ? `
                            <figure class="avatar">
                                ${d.data.photo ? 
                                    `<img src="/assets/front-end/Memberimgs/${d.data.photo}" alt="image">` 
                                    : d.data.avatar ? 
                                    `<img src="/assets/front-end/avatar/${d.data.avatar}.jpg" alt="image">` 
                                    : 
                                    `<img src="/assets/front-end/default-avatar.jpg" alt="image">`
                                }
                            </figure>
                        ` : ''
         }
                    <div class="card-details">
                        <h4 class="fw-700">${d.data.firstname || ''} ${d.data.lastname || ''}</h4>
                        ${d.data.birthdate ? `<p><strong>${birthLabel}:</strong> ${d.data.birthdate}</p>` : ''}
                    </div>
                    <div class="icons-container">
                        ${d.data.type == '1' || d.data.type == '4' ? `<a href="javascript:void(0)" data-toggle="modal" data-target="#addnewtree" data-id="${d.data.id}" data-parent-id="${d.data.parent_id}"><i class="feather-plus" title="Add"></i></a>` : ''}
                        <a href="javascript:void(0)"><i class="feather-edit" title="Edit" data-id="${d.data.id}"></i></a>
                        <a href="javascript:void(0)"><i class="feather-trash-2" title="Delete" data-id="${d.data.id}"></i></a>
                    </div>
                    </div>
                `);

                // Adjust nodes and links for partners and ex-partners
                adjustNodesAndLinks(root);

                // Adjust SVG dimensions dynamically based on the tree layout
                let minX = Infinity, maxX = -Infinity, minY = Infinity, maxY = -Infinity;
                root.descendants().forEach(d => {
                    const pos = positionMap ? positionMap.get(d.data.id) : { x: d.x, y: d.y };
                    const px = pos ? pos.x : d.x;
                    const py = pos ? pos.y : d.y;
                    if (px < minX) minX = px;
                    if (px > maxX) maxX = px;
                    if (py < minY) minY = py;
                    if (py > maxY) maxY = py;
                });
                const vbWidth = Math.max(maxX + 300, 2800);
                const vbHeight = Math.max(maxY + 300, 1200);
                d3.select('#family-tree svg').attr('viewBox', `0 0 ${vbWidth} ${vbHeight}`);
            })
            .catch(error => {
                console.error('Error fetching or processing data:', error);
                document.getElementById("family-tree").innerHTML = "<p>No Data Found</p>";
            });

        function flattenData(data) {
            const result = [];

            function addChildren(node) {
                if (!node.children) node.children = [];
                if (!node.partners) node.partners = [];
                if (!node.exPartners) node.exPartners = [];

                result.push(node);
                if (node.children) {
                    node.children.forEach(addChildren);
                }
                if (node.partners) {
                    node.partners.forEach(partner => {
                        result.push(partner);
                        if (partner.children) {
                            partner.children.forEach(addChildren);
                        }
                    });
                }
                if (node.exPartners) {
                    node.exPartners.forEach(exPartner => {
                        result.push(exPartner);
                        if (exPartner.children) {
                            exPartner.children.forEach(addChildren);
                        }
                    });
                }

            }

            data.forEach(addChildren);
            return result;
        }

        function buildTree(data) {
            const map = {};
            let rootNode;

            data.forEach(d => {
                map[d.id] = {
                    ...d,
                    children: [],
                    partners: [],
                    exPartners: []
                };
            });

            data.forEach(d => {
                if (d.parent_id === 0) {
                    rootNode = map[d.id];
                } else {
                    const parent = map[d.parent_id];
                    if (parent) {
                        parent.children.push(map[d.id]);
                    }
                }
            });

            data.forEach(d => {
                if (d.partners) {
                    d.partners.forEach(partner => {
                        const parent = map[d.id];
                        if (parent) {
                            parent.partners.push(map[partner.id]);
                        }
                    });
                }
                if (d.exPartners) {
                    d.exPartners.forEach(exPartner => {
                        const parent = map[d.id];
                        if (parent) {
                            parent.exPartners.push(map[exPartner.id]);
                        }
                    });
                }
            });

            return rootNode;
        }

        var positionMap;
        function adjustNodesAndLinks(root) {
            const ySpacing = 250;
            const partnerSpacing = 140;
            const exPartnerSpacing = -140;

            const nodeMap = new Map();
            root.descendants().forEach(node => nodeMap.set(node.data.id, node));

            positionMap = new Map();

            function adjustNodePosition(node, offsetX) {
                if (!node.children) node.children = [];
                if (!node.data.partners) node.data.partners = [];
                if (!node.data.exPartners) node.data.exPartners = [];

                const id = node.data.id;
                if (positionMap.has(id)) return;

                node.x += offsetX;
                positionMap.set(id, {
                    x: node.x,
                    y: node.y
                });

                if (node.data.partners.length > 0) {
                    node.data.partners.forEach((partner, index) => {
                        const partnerNode = nodeMap.get(partner.id);
                        if (partnerNode) {
                            partnerNode.x = node.x + partnerSpacing;
                            partnerNode.y = node.y + (index * ySpacing);
                            adjustNodePosition(partnerNode, partnerSpacing);
                        }
                    });
                }

                if (node.data.exPartners.length > 0) {
                    node.data.exPartners.forEach((exPartner, index) => {
                        const exPartnerNode = nodeMap.get(exPartner.id);
                        if (exPartnerNode) {
                            exPartnerNode.x = node.x + exPartnerSpacing;
                            exPartnerNode.y = node.y + (index * ySpacing);
                            adjustNodePosition(exPartnerNode, exPartnerSpacing);
                        }
                    });
                }

                if (node.children.length > 0) {
                    node.children.forEach(child => adjustNodePosition(child, offsetX));
                }
            }

            adjustNodePosition(root, 0);

            svg.selectAll('.node')
                .attr('transform', d =>
                    `translate(${positionMap.get(d.data.id).x},${positionMap.get(d.data.id).y})`);
        }
    });

    //Edit Member
    $('body').on('click', '.feather-edit', function() {
        let memberId = $(this).data('id');
        // Fetch modal content
        $.ajax({
            url: `/user/modal/edit/${memberId}`,
            method: 'GET',
            success: function(response) {
                // Insert modal content into the page
                $('body').append(response);
                $('#editMemberModal').modal('show');
                // Update the form action URL
                $('#editMemberForm').attr('action', `/user/members/${memberId}`);
            },
            error: function() {
                alert('An error occurred while fetching the modal.');
            }
        });
    });
    $('#editMemberForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'), // URL from the form action attribute
            method: 'PUT',
            data: $(this).serialize(), // Serialize form data
            success: function(response) {
                if (response.success) {
                    // Close modal and reload table if successful
                    $('#editMemberModal').modal('hide');
                    window.location.reload;
                } else {
                    $('#form-error').text('An error occurred. Please try again.').show();
                }
            },
            error: function(xhr) {
                $('#form-error').text('An error occurred. Please try again.').show();
            }
        });
    });

    //Delete Member
    $('body').on('click', '.feather-trash-2', function() {
        let memberId = $(this).data('id');
        $.ajax({
            url: '/user/member/' + memberId,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === 'success') {
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('An error occurred while trying to delete the member.');
            }
        });
    });

    //Add Member    
    $('#addnewtree').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var memberId = button.data('id');
        var parent_id = button.data('parent-id');
        var modal = $(this);
        if (parent_id == undefined) {
            modal.find('.modal-body #self_id').val(0);
        } else {
            modal.find('.modal-body #self_id').val(memberId);
            if (parent_id > 0) {
                modal.find('.modal-body select[name="type"] option[value="4"]').prop('disabled', true);
                modal.find('.modal-body select[name="type"] option[value="1"]').prop('selected', true);
            } else {
                modal.find('.modal-body select[name="type"] option[value="4"]').prop('disabled', false);
            }
        }

    });
</script>
<script>
    // Function to handle the avatar selection
    function selectAvatar(avatarId) {
        // Find the radio button with the given ID and check it
        document.getElementById('sradioe' + avatarId).checked = true;
    }

    // Add event listeners to each avatar label
    document.querySelectorAll('.avatar-label').forEach(label => {
        label.addEventListener('click', function() {
            // Extract the avatar ID from the 'for' attribute of the label
            const avatarId = this.getAttribute('for').replace('sradioe', '');
            selectAvatar(avatarId);
        });
    });
    $(document).ready(function() {
        $('#addnewtree').on('shown.bs.modal', function() {
            $('.nav-tabs a[href="#home"]').tab('show');
        });
    });
    document.getElementById('imgbtn').addEventListener('click', function() {
        document.getElementById('file').click();
    });

    document.getElementById('file').addEventListener('change', function() {
        if (this.files.length > 0) {
            // alert('File selected: ' + this.files[0].name);
            $('#imgbtn').html('' + this.files[0].name + '');
        }
    });

    $(document).ready(function() {
        $('#addmemberform').on('submit', function(e) {
            e.preventDefault();
            $('#form-error').hide();
            $('#addmember').prop('disabled', true);
            $('#addmember').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
            );
            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('user.addmember.store') }}",
                method: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from automatically transforming the data into a query string
                contentType: false, // Prevent jQuery from setting the Content-Type request header
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#addmember').prop('disabled', false);
                    $('#addmember').html('Save');
                    $('#form-success').text(response.message).show();
                    setTimeout(function() {
                        $('#form-success').fadeOut();
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    $('#addmember').prop('disabled', false);
                    $('#addmember').html('Save');

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '<ul>';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value +
                                '</li>'; // Append each error as list item
                        });
                        errorHtml += '</ul>';

                        // Display errors in a specific element with id="login-error"
                        $('#form-error').html(errorHtml).show();
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        // Display single error message
                        $('#form-error').text(xhr.responseJSON.message).show();
                    } else {
                        $('#form-error').text('An error occurred. Please try again.')
                            .show();
                    }
                }
            });
        });
    });
</script>
@endsection