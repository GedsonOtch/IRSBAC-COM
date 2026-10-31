<div class="lg:ml-64 p-6">

    <h1 class="text-2xl font-bold">
        Génération des relevés
    </h1>

</div>


<div class="lg:ml-64 p-6">

    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-2xl shadow">

            <div class="p-6 border-b">

                <h1 class="text-2xl font-bold">

                    Génération des relevés

                </h1>

                <p class="text-gray-500 mt-2">

                    Génération automatique des relevés
                    d'une promotion entière.

                </p>

            </div>

            <form
                action="{{ route('releves.generer') }}"
                method="POST">

                @csrf

                <div class="p-6 space-y-5">

                    <div>

                        <label class="block mb-2">

                            Filière

                        </label>

                        <select
                            name="filiere_id"
                            required
                            class="w-full border rounded-xl p-3">

                            <option value="">

                                Sélectionner

                            </option>

                            @foreach($filieres as $filiere)

                                <option
                                    value="{{ $filiere->id }}">

                                    {{ $filiere->nom }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label class="block mb-2">

                            Année d'étude

                        </label>

                        <select
                            name="annee_etude"
                            required
                            class="w-full border rounded-xl p-3">

                            <option value="1">1ère année</option>
                            <option value="2">2ème année</option>
                            <option value="3">3ème année</option>

                        </select>

                    </div>

                    <div>

                        <label class="block mb-2">

                            Année académique

                        </label>

                        <select
                            name="annee_academique_id"
                            required
                            class="w-full border rounded-xl p-3">

                            @foreach($anneesAcademiques as $anneesAcademique)
                            

                                <option
                                    value="{{ $anneesAcademique->id }}">

                                    {{ $anneesAcademique->libelle }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label class="block mb-2">

                            Semestre

                        </label>

                        <select
                            name="semestre"
                            required
                            class="w-full border rounded-xl p-3">

                            <option value="1">
                                Semestre 1
                            </option>

                            <option value="2">
                                Semestre 2
                            </option>

                            <option value="3">
                                Semestre 3
                            </option>

                            <option value="4">
                                Semestre 4
                            </option>

                            <option value="5">
                                Semestre 5
                            </option>

                            <option value="6">
                                Semestre 6
                            </option>

                        </select>

                    </div>

                </div>

                <div
                    class="p-6 border-t">

                    <button
                        class="bg-primary-900
                               text-white
                               px-6
                               py-3
                               rounded-xl">

                        Générer tous les relevés

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

