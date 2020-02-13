<?php
namespace core\backend\components\system\programming;
use core\backend\components\filesystem\file;
use core\program;

/**
 *
 */
class baker
{

  public function __construct($data)
  {

  }

    protected function format_get_function($pvar_name,$ptype,$pparent_objects_string)
    {
        $base_get_function="public get_";
        $file_content = "";

        switch ($ptype)
        {
            case "normal":
                $file_content.=$base_get_function.$pvar_name."()\n";
                $file_content.="{\n";
                $file_content.="\n";
                $file_content.="\treturn \$this->{$pvar_name};\n";
                $file_content.="\n";
                $file_content.="}\n";
                $file_content.="\n";
                break;

            case "objects":
//            $portsused = new dataset_array();
//            foreach ($this->portsused as $portused)
//            {
//                $portsused[] = new os_portused($portused);
//            }
//            return $portsused;
                $file_content.=$base_get_function.$pvar_name."()\n";
                $file_content.="\t{".CRLF;
                $file_content.=CRLF;
                $file_content.="\t\$_{$pvar_name} = new dataset_array();".CRLF;
                $file_content.="\tforeach (\$this->{$pvar_name} as \$item)\n";
                $file_content.="\t{\n";
                $file_content.="\t\t\n";
                $file_content.="\t\t\$_{$pvar_name}[] = new {$pparent_objects_string}_{$pvar_name}(\$item);\n";
                $file_content.="\t\t\n";
                $file_content.="\t}\n";
                $file_content.="\treturn \$_{$pvar_name};\n";
                $file_content.="\n";
                $file_content.="\t}\n";
                $file_content.="\n";

                break;

            case "object":
                // return new os_portused($this->portused)
                $file_content.="\t".$base_get_function.$pvar_name."()\n";
                $file_content.="\t{\n";
                $file_content.="\n";
                $file_content.="\treturn new {$pparent_objects_string}_{$pvar_name}(\$this->{$pvar_name});\n";
                $file_content.="\n";
                $file_content.="\t}\n";
                $file_content.="\n";
                break;
        }
        return $file_content;
    }

    protected function format_uses($pclass_name)
    {
        $file_content = "";
        $file_content.="use {$pclass_name};\n";
        $file_content.="\n";
        return $file_content;
    }

    public function format_header($pclass_name,$pnamespace)
    {
//        "
//    <?php
//    namespace _namespace_;
//    use core\backend\database\dataset;
//    use core\backend\database\dataset_array;
//    _uses_string_
//

        $file_content = "";
        $file_content.="<?php";
        $file_content.="namespace ".$pnamespace;
        $file_content.="use core\backend\database\dataset;";
        $file_content.="use core\backend\database\dataset_array;";
        return $file_content;

    }

    public function format_body($pclass_name)
    {
//    class _object_name_ extends dataset
//    {
//
//      _variables_string_
//
//      _functions_string_
//
//    }";
        $file_content = "";
        $file_content.="\tclass {$pclass_name} extends dataset\n";
        $file_content.="\t{\n";
        return $file_content;
    }

    protected function format_variable($pvariable_name,$pdata)
    {
        $file_content = "";
        $base_comment='// type : ';
        $base_variable_string = "protected ";

        $file_content.=$base_comment.gettype($pdata)."\n";
        $file_content.= $base_variable_string.$pvariable_name.";\n";
        $file_content.="\n";
        return $file_content;
    }

// need to add check to know if in a child or the root object for namespace and class purpose

  public function parse_root_object($data_object, $pclass_name= "test")
  {
      $namespace = $pclass_name;
      $class = $this->create_class_file($pclass_name);
      $class_header = $this->format_class($pclass_name,$namespace);
      $class_body = "";
      $class->add_contents();

      foreach(get_object_vars($data_object) as $name => $data)
      {
          if (\is_array($data))
          {
              if(is_object($data[0]))
              {
                  $class_body.=$this->format_get_function($name,"objects","");
                  $class_body.=$this->format_variable($name,$data);
                  $class_header.=$class->add_contents($this->format_uses($name));
                  $this->parse_root_object($data[0],$name);
              }
          }
          elseif (is_object($data))
          {
              $class_body.=$this->format_get_function($name,"object","");
              $class_body.=$this->format_variable($name,$data);
              $class_header.=$class->add_contents($this->format_uses($name));
              $this->parse_root_object($data);
          }
          else
          {
              $class_body.=$this->format_get_function($name,"normal","");
              $class_body.=$this->format_variable($name,$data);
          }
      }
      $class->add_contents($class_header);
      $class->add_contents($class_body);
  }

  public function create_class_file($pclass_name)
  {
    $class = new file(program::$path.'/core/backend/programs/baked_file/'.$pclass_name.'.php');
    return $class;
  }
}
