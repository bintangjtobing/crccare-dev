<?php

namespace App\Http\Controllers;

use Mail;
use App\FileChemical;
use App\Chemical;
use App\FileDocument;
use App\humanimpact;
use App\ScoreResult;
use App\File;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * TODO: move to repository
     */
    private function deleteFileDocumentById($id)
    {
        $document = FileDocument::find($id);

        // remove the actual file from storage
        Storage::disk('uploads')->delete("documents/{$document->file}");

        $document->delete();
    }

    public function index()
    {
        return view('welcome');
    }

    /**
     * check if file name is duplicated for that particular user
     * exclude file name of the file record if `id` is defined
     */
    public function checkFile(Request $req)
    {
        $data = $req->all();
        $sameNameFile = File::where('filename', $data['name'])
            ->where('userId', Auth::id())
            ->first();
        if (isset($data['id']) && isset($sameNameFile) && $sameNameFile->id === $data['id']) {
            return response()->json(['existingName' => false]);
        }
        return response()->json(['existingName' => isset($sameNameFile)]);
    }

    public function addChemical(Request $request)
    {
        $chemical = new Chemical();
        $chemical->name = $request->name;
        $chemical->formula = $request->formula;
        $chemical->oralR = $request->oralR;
        $chemical->oralS = $request->oralS;
        $chemical->save();
        return request()->json($chemical);
    }

    public function viewDataScore($id)
    {
        $scoreData = DB::table('score_results')
            ->join('summaryfiles', 'score_results.summaryid', '=', 'summaryfiles.id')
            ->join('chemicaldatas', 'summaryfiles.id', '=', 'chemicaldatas.summaryfileid')
            ->join('chemicallist', 'chemicaldatas.chemicalid', '=', 'chemicallist.id')
            ->where('score_results.id', '=', $id)
            ->select('score_results.*', 'summaryfiles.*', 'chemicaldatas.chemicalid', 'chemicaldatas.CiS', 'chemicaldatas.CiG', 'chemicaldatas.CiSW', 'chemicallist.chemical_name')
            ->get();
        return response()->json($scoreData);
    }

    public function getChemicals()
    {
        return response()->json(Chemical::all());
    }

    public function getFileChemicals()
    {
        $chemicals = FileChemical::where('fileId', 0)->get();
        return response()->json($chemicals);
    }
    public function countDataFiles()
    {
        $dataFiles = DB::table('score_results')
            ->join('users', 'score_results.userId', '=', 'users.id')
            ->join('files', 'score_results.fileId', '=', 'files.id')
            ->selectRaw('users.id, count(score_results.userId) as totalData, GROUP_CONCAT(files.filename) as fileName,GROUP_CONCAT(score_results.scoreAdult) as scoreAdult,GROUP_CONCAT(score_results.scoreChildren) as scoreChildren, users.name as userName')
            ->groupBy('users.id', 'users.name')
            ->get();
        return $dataFiles;
    }

    public function getScore(Request $req)
    {
        $statsData = $req->query('statsData', 0);
        $getCurrentUser = User::find(Auth::id());
        if (($getCurrentUser->role === 'admin') || $statsData) {
            return response()->json(ScoreResult::all());
        } else {
            return response()->json(ScoreResult::where('userId', $getCurrentUser->id)->get());
        }
    }

    public function getFiles()
    {
        return response()->json(File::all());
    }

    public function getHumanImpacts()
    {
        $humanimpacts = humanimpact::where('summaryFileId', 0)->get();
        return response()->json($humanimpacts);
    }

    public function getChemicalById($id)
    {
        return response()->json(Chemical::find($id));
    }

    public function addFileChemical()
    {
        $fileChemical = FileChemical::create([
            'chemicalId' => request()->chemicalId,
            'CiS' => request()->concentrationSoil,
            'CiG' => request()->concentrationGroundWater,
            'CiSW' => request()->concentrationSurfaceWater,
        ]);
        return response()->json($fileChemical);
    }

    public function addHumanImpact()
    {
        $humanImpact = humanimpact::create([
            'userid' => Auth::id(),
            'chemicalDataId' => request()->chemicalDataId,
            'WoHR' => request()->wohr,
            'AoS' => request()->aos,
            'GEP' => request()->gep,
            'HGC' => request()->hgc,
            'HGCo' => request()->hgco,
            'HGC' => request()->hgc,
            'SWEP' => request()->swep,
            'HSWC' => request()->hswc,
            'HSWCo' => request()->hswco,
            'wTGHQ' => request()->wtghq,
            'wTGHQo' => request()->wtghqo,
            'wTGHQS' => request()->wtghqs,
            'wTGHQSo' => request()->wtghqso,
            'f5tghqc' => request()->f5tghqc,
            'f6tghqc' => request()->f6tghqc,
            'f7tghqc' => request()->f7tghqc,
            'f8tghqc' => request()->f8tghqc,
            'f5tghqa' => request()->f5tghqa,
            'f6tghqa' => request()->f6tghqa,
            'f7tghqa' => request()->f7tghqa,
            'f8tghqa' => request()->f8tghqa,
        ]);
        print($humanImpact);
        return response()->json(humanimpact::find($humanImpact->id));
    }

    public function deleteChemical($id)
    {
        $chemi = chemicallist::find($id);
        $chemi->delete();
    }

    public function deleteFileChemical($id)
    {
        FileChemical::find($id)->delete();
        return response()->noContent();
    }

    public function getChemicalList($id)
    {
        $chemicalListGet = chemicallist::find($id);
        return response()->json($chemicalListGet);
    }

    public function updateChemical($id, Request $request)
    {
        $chemical = Chemical::find($id);
        $chemical->name = $request->name;
        $chemical->formula = $request->formula;
        $chemical->oralR = $request->oralR;
        $chemical->oralS = $request->oralS;
        $chemical->save();
        return response()->json($chemical);
    }

    public function getCountFilename()
    {
        $filesCount = DB::table('score_results')
            ->where('userid', '=', Auth::id())
            ->get()
            ->count();
        $totalFiles = DB::table('score_results')
            ->get()
            ->count();
        return response()->json(array('filesCount' => $filesCount, 'totalFiles' => $totalFiles));
    }

    public function createFile()
    {
        $data = request()->all();

        // save input data
        $file = File::create([
            'userId' => Auth::id(),
            'filename' => $data['filename']['name'],
            'description' => $data['filename']['desc'],
            'weightOnHumanRisk' => $data['weightOnHumanRisk'],
            'areaOfSoil' => $data['areaOfSoil'],
            'groundWaterExposure' => $data['groundWaterExposure'],
            'groundWaterConsumptionChild' => $data['groundWaterConsumption']['child'],
            'groundWaterConsumptionAdult' => $data['groundWaterConsumption']['adult'],
            'surfaceWaterExposure' => $data['surfaceWaterExposure'],
            'surfaceWaterConsumptionChild' => $data['surfaceWaterConsumption']['child'],
            'surfaceWaterConsumptionAdult' => $data['surfaceWaterConsumption']['adult'],
            'aquaticRisk' => $data['aquaticRisk'],
            'erosionType' => $data['erosionType'],
            'erosionValueObservation' => array_key_exists('observation', $data['erosionValue']) ? $data['erosionValue']['observation'] : 0,
            'erosionValueRUSLE' => array_key_exists('rusle', $data['erosionValue']) ? $data['erosionValue']['rusle'] : 0,
            'growthRateAquatic' => $data['growthRateAquatic'],
            'growthRateTerrestrial' => $data['growthRateTerrestrial'],
            'levelOfContaminant' => $data['groundWaterImpact']['levelOfContaminant'],
            'splp' => $data['groundWaterImpact']['splp'],
            'groundWaterDepth' => $data['groundWaterImpact']['groundWaterDepth'],
            'offsiteImpact' => $data['groundWaterImpact']['offsiteImpact'],
            'nearestBorehole' => $data['groundWaterImpact']['nearestBorehole'],
            'institutionControl' => $data['groundWaterImpact']['institutionControl'],
        ]);

        // save file chemicals
        foreach ($data['fileChemicals'] as $fileChemical) {
            FileChemical::create([
                'chemicalId' => $fileChemical['chemicalId'],
                'CiS' => $fileChemical['CiS'],
                'CiG' => $fileChemical['CiG'],
                'CiSW' => $fileChemical['CiSW'],
                'fileId' => $file->id,
            ]);
        }

        FileDocument::whereIn('id', request()->documentIds)->update(['fileId' => $file->id]);

        // save score
        $score = ScoreResult::create([
            'userId' => Auth::id(),
            'fileId' => $file->id,
            'scoreChildren' => request()->score['child'],
            'scoreAdult' => request()->score['adult'],
            'FChildren' => request()->score['FChildren'],
            'FAdult' => request()->score['FAdult'],
            'ecologicalImpactScore' => request()->score['ecologicalImpactScore'],
            'humanImpactChild' => request()->score['humanImpactChild'],
            'humanImpactAdult' => request()->score['humanImpactAdult'],
            'G' => request()->score['G'],
        ]);

        return response()->JSON($score);
    }

    public function updateScore($id)
    {
        $data = request()->all();
        $scoreResult = ScoreResult::find($id);
        if (!$scoreResult) return request()->json(['message' => 'File not found'], 404);
        $file = File::find($scoreResult->fileId);

        // update file data
        $file->filename = $data['filename']['name'];
        $file->description = $data['filename']['desc'];
        $file->weightOnHumanRisk = $data['weightOnHumanRisk'];
        $file->areaOfSoil = $data['areaOfSoil'];
        $file->groundWaterExposure = $data['groundWaterExposure'];
        $file->groundWaterConsumptionChild = $data['groundWaterConsumption']['child'];
        $file->groundWaterConsumptionAdult = $data['groundWaterConsumption']['adult'];
        $file->surfaceWaterExposure = $data['surfaceWaterExposure'];
        $file->surfaceWaterConsumptionChild = $data['surfaceWaterConsumption']['child'];
        $file->surfaceWaterConsumptionAdult = $data['surfaceWaterConsumption']['adult'];
        $file->aquaticRisk = $data['aquaticRisk'];
        $file->erosionType = $data['erosionType'];
        $file->erosionValueObservation = array_key_exists('observation', $data['erosionValue']) ? $data['erosionValue']['observation'] : 0;
        $file->erosionValueRUSLE = array_key_exists('rusle', $data['erosionValue']) ? $data['erosionValue']['rusle'] : 0;
        $file->growthRateAquatic = $data['growthRateAquatic'];
        $file->growthRateTerrestrial = $data['growthRateTerrestrial'];
        $file->levelOfContaminant = $data['groundWaterImpact']['levelOfContaminant'];
        $file->splp = $data['groundWaterImpact']['splp'];
        $file->groundWaterDepth = $data['groundWaterImpact']['groundWaterDepth'];
        $file->offsiteImpact = $data['groundWaterImpact']['offsiteImpact'];
        $file->nearestBorehole = $data['groundWaterImpact']['nearestBorehole'];
        $file->institutionControl = $data['groundWaterImpact']['institutionControl'];
        $file->save();

        // update chemical data
        $existingIds = [];
        $newChemicals = [];
        foreach ($data['fileChemicals'] as $fileChemical) {
            if (isset($fileChemical['id'])) {
                array_push($existingIds, $fileChemical['id']);
            } else {
                array_push($newChemicals, $fileChemical);
            }
        }

        $existingFileChemicalIds = [];
        foreach ($file->chemicals as $fileChemical) {
            array_push($existingFileChemicalIds, $fileChemical->id);
        }

        // check if some existing chemicals are deleted
        $deletedIds = array_diff($existingFileChemicalIds, $existingIds);
        if (!empty($deletedIds)) {
            FileChemical::destroy($deletedIds);
        }

        // insert new records
        foreach ($newChemicals as $fileChemical) {
            FileChemical::create([
                'chemicalId' => $fileChemical['chemicalId'],
                'CiS' => $fileChemical['CiS'],
                'CiG' => $fileChemical['CiG'],
                'CiSW' => $fileChemical['CiSW'],
                'fileId' => $file->id,
            ]);
        }

        // handle update file uploads
        $existingDocumentIds = [];
        foreach ($file->documents as $doc) {
            array_push($existingDocumentIds, $doc->id);
        }
        $deletedIds = array_diff($existingDocumentIds, $data['documentIds']);
        $newIds = array_diff($data['documentIds'], $existingDocumentIds);

        foreach ($deletedIds as $docId) {
            $this->deleteFileDocumentById($docId);
        }

        FileDocument::whereIn('id', $newIds)->update(['fileId' => $file->id]);

        // update score
        $scoreResult->scoreChildren = $data['score']['child'];
        $scoreResult->scoreAdult = $data['score']['adult'];
        $scoreResult->FChildren = $data['score']['FChildren'];
        $scoreResult->FAdult = $data['score']['FAdult'];
        $scoreResult->ecologicalImpactScore = $data['score']['ecologicalImpactScore'];
        $scoreResult->humanImpactChild = $data['score']['humanImpactChild'];
        $scoreResult->humanImpactAdult = $data['score']['humanImpactAdult'];
        $scoreResult->G = $data['score']['G'];
        $scoreResult->save();

        // return data
        $scoreResult = ScoreResult::find($id);
        return response()->json($scoreResult);
    }

    public function getScoreResultById($id)
    {
        return response()->JSON(ScoreResult::find($id));
    }

    public function getVal()
    {
        $currentUser = User::find(Auth::id());
        if ($currentUser->role === 'admin') {
            $score = DB::table('score_results as w')
                ->select(array(DB::Raw('COUNT(w.created_at) as countValue'), DB::Raw('DATE(w.created_at) day')))
                ->groupBy('day')
                ->orderBy('day')
                ->get();
            return
                response()->JSON($score);
        } else {
            $score = DB::table('score_results as w')
                ->select(array(DB::Raw('COUNT(w.created_at) as countValue'), DB::Raw('DATE(w.created_at) day')))
                ->where('userId', '=', $currentUser->id)
                ->groupBy('day')
                ->orderBy('day')
                ->get();
            return
                response()->JSON($score);
        }
    }
    public function deleteDataResult($id)
    {
        $scoreFind = ScoreResult::find($id);
        $summaryFind = File::find($scoreFind->id);
        $chemicalDataFind = FileChemical::where('fileId', $summaryFind->id)->delete();
        $summaryFind->delete();
        $scoreFind->delete();
    }
}
