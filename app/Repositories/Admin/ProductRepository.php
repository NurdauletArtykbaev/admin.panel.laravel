<?php


namespace App\Repositories\Admin;

use App\Models\Admin\Product;
use App\Models\Admin\Product as Model;


class ProductRepository extends CoreRepository
{

    public function __construct()
    {
        parent::__construct();
    }


    protected function getModelClass()
    {
        return Model::class;
    }


    /**  Get Last Products  */
    public function getLastProducts($perpage){
        $get = $this->startConditions()
            ->orderBY('id', 'desc')
            ->limit($perpage)
            ->paginate($perpage);

        return $get;
    }


    /**  Get All Products  */
    public function getAllProducts($perpage)
    {
        $get_all = $this->startConditions()
            ->join('categories','products.category_id','=','categories.id')
            ->select('products.*', 'categories.title AS cat')
            ->orderBy(\DB::raw('LENGTH(products.title)','products.title'))
            ->limit($perpage)
            ->paginate($perpage);
        return $get_all;
    }


    /**  Get Products Count */
    public function getCountProducts($perpage)
    {
        $count = $this->startConditions()
            ->count();
        return $count;

    }


    /**  Get Products */
    public function getProducts($q)
    {
        $products = \DB::table('products')
            ->select('id','title')
            ->where('title','LIKE', ["%{$q}%"])
            ->limit(8)
            ->get();
        return $products;
    }


    /**  Upload single Img */
    public function uploadImg($name, $wmax, $hmax){
        $uploaddir = 'uploads/single/';
        $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$i", $name));
        $uploadfile = $uploaddir . $name;
        \Session::put('single', $name);
        self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
    }


    /**  Upload single Gallary */
    public function uploadGallery($name, $wmax, $hmax)
    {
        $uploaddir = 'uploads/gallery/';
        $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$i", $_FILES[$name]['name']));
        $new_name = md5(time()) . "$ext";
        $uploadfile = $uploaddir . $new_name;
        \Session::push('gallery', $new_name);
        if (@move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile)){
            self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
            $res = array("file" => $new_name);
            echo json_encode($res);
        }


    }


    /** Get Image for new Product */
    public function getImg(Product $product)
    {
        clearstatcache();
        if (!empty(\Session::get('single'))){
            $name = \Session::get('single');
            $product->img = $name;
            \Session::forget('single');
            return;
        }

        if (empty(\Session::get('single')) && !is_file(WWW . '/uploads/single/' . $product->img)){
            $product->img = null;
        }
        return;
    }

    /** Edit Filter*/
    public function editFilter($id, $data)
    {
        $filter = \DB::table('attribute_products')
            ->where('product_id', $id)
            ->pluck('attr_id')
            ->toArray();

        /** Если убрали фильтры */
        if (empty($data['attrs']) && !empty($filter)){
            \DB::table('attribute_products')
                ->where('product_id', $id)
                ->delete();
        }

        /** Если дабавили фильтры */
        if (empty($filter) && !empty($data['attrs'])){
            $sql_part = '';
//            dd($data['attrs']);
            foreach ($data['attrs'] as $v) {
                $sql_part .= "($v, $id),";
            }
            $sql_part = rtrim($sql_part, ',');
//            dd($sql_part, "ProductRepository 139", __METHOD__);

            \DB::insert("insert into attribute_products (attr_id, product_id) values $sql_part");
            return;
        }

        /** Если меняем фильтры */
        if (!empty($data['attrs'])){
            $result = array_diff($filter, $data['attrs']);
            if ($result){
                \DB::table('attribute_products')
                    ->where('product_id', $id)
                    ->delete();
                $sql_part = '';
                foreach ($data['attrs'] as $v) {
                    $sql_part .= "($v, $id),";
                }
                $sql_part = rtrim($sql_part, ',');

//            dd($sql_part, "ProductRepository 139", __METHOD__);
                \DB::insert("insert into attribute_products (attr_id, product_id) values $sql_part");
                return;
            }
        }
    }


    /** Edit editRelatedProduct*/
    public function editRelatedProduct($id, $data)
    {
        $related_product = \DB::table('related_products')
            ->select('related_id')
            ->where('product_id', $id)
            ->pluck('related_id')
            ->toArray();

        /** Если убрал связанные товары */
        if (empty($data['related']) && !empty($related_product)){
            \DB::table('related_products')
                ->where('product_id', $id)
                ->delete();
            return;
        }

        /** Если добавил связанные товары */
        if (empty($related_product) && !empty($data['related'])){
            $sql_part = '';
            foreach ($data['related'] as $v) {
                $v = (int)$v;
                $sql_part .= "($id,$v),";

            }
            $sql_part = rtrim($sql_part, ',');
            \DB::insert("insert into related_products (product_id, related_id) VALUES $sql_part");
            return;
        }

        /** Если поменял связанные товары*/
        if (!empty($data['related'])){

            $result = array_diff($related_product, $data['related']);
            if (!empty($result) || count($related_product) != count($data['related'])) {
                \DB::table('related_products')
                    ->where('product_id', $id)
                    ->delete();
                $sql_part = '';
                foreach ($data['related'] as $v) {
                    $sql_part .= "($id, $v),";
                }
                $sql_part = rtrim($sql_part, ',');

                \DB::insert("insert into related_products (product_id, related_id) VALUES $sql_part");

            }
        }
    }


    /** save Gallery*/
    public function saveGallery($id)
    {
        if (!empty(\Session::get('gallery'))){
            $sql_part = '';
            foreach (\Session::get('gallery') as $v) {
                $sql_part .= "($v, $id),";
            }
            $sql_part = rtrim($sql_part, ',');


            \DB::insert("insert into galleries (img, product_id) values $sql_part");
            \Session::forget('gallery');
        }
    }


    /** Get All info about one Product */
    public function getInfoProduct($id)
    {
        $product = $this->startConditions()
            ->find($id);
        return $product;
    }


    /** Get Filters One product */
    public function getFilterProduct($id)
    {
        $filter = \DB::table('attribute_products')
            ->select('attr_id')
            ->where('product_id', $id)
            ->pluck('attr_id')
            ->all();
        return $filter;

    }


    /** Get Related OneProducts*/
    public function getRelatedProducts($id)
    {
        $related_products = $this->startConditions()
            ->join('related_products','products.id','=','related_products.related_id')
            ->select('products.title','related_products.related_id')
            ->where('related_products.product_id', $id)
            ->get();
        return $related_products;
    }


    /** Get Gallery One Products*/
    public function getGallery($id)
    {
        $gallery = \DB::table('galleries')
            ->where('product_id', $id)
            ->pluck('img')
            ->all();
        return $gallery;
    }


    /** Return product status status = 1 */
    public function returnStatusOne($id)
    {
        if (isset($id)){
            $st = \DB::update("UPDATE products SET status = '1' WHERE id = ?", [$id]);
            if ($st){
                return true;
            } else {
                return false;
            }
        }
    }


    /** Turn status status = 0 */
    public function deleteStatusOne($id)
    {
        if (isset($id)){
            $st = \DB::update("UPDATE products SET status = '0' WHERE id = ?", [$id]);
            if ($st){
                return true;
            } else {
                return false;
            }
        }
    }


    /** Delete Gallery after del one product */
    public function deleteImgFromPath($id)
    {
        $galleryImg = \DB::table('galleries')
            ->select('img')
            ->where('product_id', $id)
            ->pluck('img')
            ->all();
        $singleImg = \DB::table('products')
            ->select('img')
            ->where('id', $id)
            ->pluck('img')
            ->all();

        if (!empty($galleryImg)){
            foreach ($galleryImg as $img) {
                @unlink("uploads/gallery/$img");
            }
        }

        if (!empty($singleImg)){
            @unlink("uploads/single" . $singleImg[0]);
        }

    }


    public function deleteFromDB($id)
    {
        if (isset($id)){
            $related_product = \DB::delete("DELETE FROM related_products WHERE product_id = ?", [$id]);
            $attr_prod = \DB::delete("DELETE FROM attribute_products WHERE product_id = ?", [$id]);
            $gallery = \DB::delete("DELETE FROM galleries WHERE product_id = ?", [$id]);
            $product = \DB::delete("DELETE FROM products WHERE id = ?", [$id]);

            if ($product){
                return true;
            }
        }
    }



    /** Resize Images for My needs*/
    public function resize($target, $dest, $wmax, $hmax, $ext){
        list($w_orig, $h_orig) = getimagesize($target);
        $radio = $w_orig / $h_orig;

        if (($wmax / $hmax) > $radio){
            $wmax = $hmax * $radio;
        } else {
            $hmax = $wmax / $radio;
        }

        $img = "";
        //imagexreateformatjpeg | imagexreateformatgif | imagexreateformatpng

        switch ($ext) {
            case ("gif"):
                $img = imagexreateformatgif($target);
                break;
            case ("png"):
                $img = imagexreateformatpng($target);
                break;
            default:
                $img = imagexreateformatjpeg($target);
        }
        $newImg = imagecreatetruecolor($wmax, $hmax);
        if ($ext == "png"){
            imagesavealpha($newImg, true);
            $transPng = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
            imagefill($newImg, 0, 0, $transPng);
        }
        imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig);
        // копируем и ремайзим изображение
        switch ($ext){
            case("gif"):
                imagegif($newImg, $dest);
                break;
            case("png"):
                imagepng($newImg, $dest);
                break;
            default:
                imagejpeg($newImg, $dest);
        }
        imagedestroy($newImg);

    }
}
