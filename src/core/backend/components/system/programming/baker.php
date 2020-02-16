<?php
namespace core\backend\components\system\programming;
use core\backend\components\filesystem\file;
use core\program;

/**
 *
 */
class baker
{

    public function bake($data_std_class)
    {
        $this->parse_root_object(json_decode($data_std_class));
    }

    // possible future refactor : change this function to three seperate get function types
    protected function format_get_function($pvar_name,$ptype,$pparent_objects_string)
    {
        $base_get_function="\tpublic function get_";
        $file_content = "";

        switch ($ptype)
        {
            case "normal":
                $file_content.=$base_get_function.$pvar_name."()\n";
                $file_content.="\t{\n";
                $file_content.="\t\treturn \$this->{$pvar_name};\n";
                $file_content.="\t}\n";
                $file_content.="\t\n";
                break;

            case "objects":
                $file_content.="".$base_get_function.$pvar_name."()\n";
                $file_content.="\t{".CRLF;
                $file_content.="\t\t\$_{$pvar_name} = new dataset_array();".CRLF;
                $file_content.="\t\tforeach (\$this->{$pvar_name} as \$item)\n";
                $file_content.="\t\t{\n";;
                $file_content.="\t\t\t\$_{$pvar_name}[] = new {$pparent_objects_string}{$pvar_name}(\$item);\n";
                $file_content.="\t\t}\n";
                $file_content.="\t\treturn \$_{$pvar_name};\n";
                $file_content.="\t}\n";
                $file_content.="\t\n";
                break;

            case "object":
                $file_content.=$base_get_function.$pvar_name."()\n";
                $file_content.="\t{\n";
                $file_content.="\t\treturn new {$pparent_objects_string}{$pvar_name}(\$this->{$pvar_name});\n";
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
        return $file_content;
    }

    public function format_header($pclass_name,$pnamespace)
    {

        $file_content = "";
        $file_content.="<?php\n";
        $file_content.="namespace ".$pnamespace.";\n";
        $file_content.="use core\backend\database\dataset;\n";
        $file_content.="use core\backend\database\dataset_array;\n";
        return $file_content;

    }

    public function format_body($pclass_name)
    {
        $file_content="";
        $file_content.="\n";
        $file_content.="class {$pclass_name} extends dataset\n";
        $file_content.="{\n";
        $file_content.="\n";
        return $file_content;
    }

    protected function format_variable($pvariable_name,$pdata)
    {
        $file_content = "";
        $base_comment="\t// type : ";
        $base_variable_string = "\tprotected ";

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
      $class_header = $this->format_header($pclass_name,$namespace);
      $class_variables = "";
      $class_functions = "";
      $class_body = $this->format_body($pclass_name);
      foreach(get_object_vars($data_object) as $name => $data)
      {
          if (\is_array($data))
          {
              if(is_object($data[0]))
              {
                  $class_variables.=$this->format_variable($name, new \stdClass());
                  $class_functions.=$this->format_get_function($name,"objects","");
                  $class_header.=$this->format_uses($name);
                  $this->parse_root_object($data[0],$name);
              }
          }
          elseif (is_object($data))
          {
              $class_variables.=$this->format_variable($name,$data);
              $class_functions.=$this->format_get_function($name,"object","");
              $class_header.=$this->format_uses($name);
              $this->parse_root_object($data,$name);
          }
          else
          {
              $class_variables.=$this->format_variable($name,$data);
              $class_functions.=$this->format_get_function($name,"normal","");
          }
      }
      $class->set_contents("");
      $class->add_contents($class_header);
      $class->add_contents($class_body);
      $class->add_contents($class_variables);
      $class->add_contents($class_functions);
      $class->add_contents("}");
  }

  public function create_class_file($pclass_name)
  {
    $class = new file(program::$path.'/core/backend/programs/baked_file/'.$pclass_name.'.php');
    return $class;
  }
}
