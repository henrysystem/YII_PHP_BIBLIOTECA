<?php

namespace app\controllers;

use app\models\Libro;
use app\models\LibroSearch;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\Pagination;

/**
 * LibroController implements the CRUD actions for Libro model.
 */
class LibroController extends Controller
{
  /**
   * @inheritDoc
   */
  public function behaviors()
  {
    return array_merge(
      parent::behaviors(),
      [
        'access' => [
          'class' => AccessControl::class,
          'rules' => [
            [
              'allow' => true,
              'roles' => ['@']
            ]
          ]
        ],
        'verbs' => [
          'class' => VerbFilter::class,
          'actions' => [
            'delete' => ['POST'],
          ],
        ],
      ]
    );
  }

  /**
   * Lists all Libro models.
   *
   * @return string
   */
  public function actionIndex()
  {
    $searchModel = new LibroSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Libro model.
   * @param int $lb_codigo Lb Codigo
   * @return string
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($lb_codigo)
  {
    return $this->render('view', [
      'model' => $this->findModel($lb_codigo),
    ]);
  }

  /**
   * Creates a new Libro model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate()
  {
    $model = new Libro();

    $this->subirFoto($model);


    return $this->render('create', [
      'model' => $model,
    ]);
  }

  /**
   * Updates an existing Libro model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param int $lb_codigo Lb Codigo
   * @return string|\yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($lb_codigo)
  {
    $model = $this->findModel($lb_codigo);
    $this->subirFoto($model);

    return $this->render('update', [
      'model' => $model,
    ]);
  }

  /**
   * Deletes an existing Libro model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param int $lb_codigo Lb Codigo
   * @return \yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($lb_codigo)
  {
    $model = $this->findModel($lb_codigo);
    if (file_exists($model->imagen)) {
      unlink($model->imagen);
    }

    $model->delete();

    return $this->redirect(['index']);
  }

  public function actionLista()
  {
    $model = Libro::find();
    return $this->render('lista');
    # code...
  }
  /**
   * Finds the Libro model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $lb_codigo Lb Codigo
   * @return Libro the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($lb_codigo)
  {
    if (($model = Libro::findOne(['lb_codigo' => $lb_codigo])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }

  protected  function subirFoto(Libro $model)
  {
    if ($this->request->isPost) {
      if ($model->load($this->request->post()) && $model->save()) {
        $model->archivo = UploadedFile::getInstance($model, 'archivo');
        if ($model->validate()) {
          if ($model->archivo) {
            if (file_exists($model->imagen)) {
              unlink($model->imagen);
            }
            $rutaArchivo = 'uploads/' . time() . "_" . $model->archivo->baseName . "." . $model->archivo->extension;
            if ($model->archivo->saveAs($rutaArchivo)) {
              $model->imagen = $rutaArchivo;
            }
          }
        }
        if ($model->save(false)) {
          return $this->redirect(['index']);
        }
      }
    } else {
      $model->loadDefaultValues();
    }
  }
}
