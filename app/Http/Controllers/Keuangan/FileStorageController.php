<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Keuangan\PengajuanDana,
    Keuangan\JurnalHarian,
    Keuangan\ResumeJurnal,
    Keuangan\RealisasiDana,
    Keuangan\ProgressKeuangan,

    Umum\ItemAsetPerusahaan,
    Umum\InventoriPerusahaan,
    Umum\LaporanKegiatan,
    Umum\ItemLegalitasPerusahaan,
    Umum\SdmPerusahaan,

    Marketing\ItemMarketing,

    Konstruksi\LaporanHarian,
    Konstruksi\ItemProgressKemajuan,
    Konstruksi\PhotoKegiatan,
    Konstruksi\ControlStock,
    Konstruksi\ResumeKegiatan,
    Konstruksi\PerjanjianKontrak,
    
    Perencanaan\FinancialAnalysis,
    Perencanaan\GambarUnitRumah,
    Perencanaan\ItemUnitRumah,
    Perencanaan\ItemKonstruksiSarana,
    Perencanaan\BrosurPerumahan,
};

class FileStorageController extends Controller
{
    public function imagePengajuanDana($id)
    {
        $file = PengajuanDana::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }

    public function imageJurnalHarian($id)
    {
        $file = JurnalHarian::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }
    public function imageResumeJurnal($id)
    {
        $file = ResumeJurnal::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }
    public function imageRealisasiDana($id)
    {
        $file = RealisasiDana::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }
    public function imageProgressKeuangan($id)
    {
        $file = ProgressKeuangan::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }

    public function imageItemAsetPerusahaan($id)
    {
        $file = ItemAsetPerusahaan::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }
    public function imageInventoriPerusahaan($id)
    {
        $file = InventoriPerusahaan::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }
    public function imageLaporanKegiatan($id)
    {
        $file = LaporanKegiatan::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }
    public function imageItemLegalitasPerusahaan($id)
    {
        $file = ItemLegalitasPerusahaan::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }
    public function imageSdmPerusahaan($id)
    {
        $file = SdmPerusahaan::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }
    public function imageItemMarketing($id)
    {
        $file = ItemMarketing::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }

    public function imageLaporanHarian($id)
    {
        $file = LaporanHarian::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }

    public function imageItemProgressKemajuan($id)
    {
        $file = ItemProgressKemajuan::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }

    public function imagePhotoKegiatan($id)
    {
        $file = PhotoKegiatan::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }

    public function imageControlStock($id)
    {
        $file = ControlStock::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }

    public function imageResumeKegiatan($id)
    {
        $file = ResumeKegiatan::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }

    public function imagePerjanjianKontrak($id)
    {
        $file = PerjanjianKontrak::findOrFail($id);
        $path = storage_path('app/'.$file->image_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'image'));
            
        }
        
        abort(404);
    }

    public function pdfFinancialAnalysis($id)
    {
        $file = FinancialAnalysis::findOrFail($id);
        $path = storage_path('app/'.$file->pdf_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'application/pdf'));
            
        }
        
        abort(404);
    }
    public function pdfGambarUnitRumah($id)
    {
        $file = GambarUnitRumah::findOrFail($id);
        $path = storage_path('app/'.$file->pdf_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'application/pdf'));
            
        }
        
        abort(404);
    }
    public function pdfItemUnitRumah($id)
    {
        $file = ItemUnitRumah::findOrFail($id);
        $path = storage_path('app/'.$file->pdf_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'application/pdf'));
            
        }
        
        abort(404);
    }
    public function pdfItemKonstruksiSarana($id)
    {
        $file = ItemKonstruksiSarana::findOrFail($id);
        $path = storage_path('app/'.$file->pdf_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'application/pdf'));
            
        }
        
        abort(404);
    }
    public function pdfBrosurPerumahan($id)
    {
        $file = BrosurPerumahan::findOrFail($id);
        $path = storage_path('app/'.$file->pdf_path);
        
        if (file_exists($path)) {
            
            return response()
            ->file($path, array('Content-Type' =>'application/pdf'));
            
        }
        
        abort(404);
    }
}
